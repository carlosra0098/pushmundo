<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_requires_authentication()
    {
        $response = $this->get('/profile');
        $response->assertStatus(302); // redirect to login
    }

    public function test_authenticated_user_can_view_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->email);
        $response->assertSee('Editar perfil');
        $response->assertSee('Cambiar contraseña');
        $response->assertSee('Actividad reciente');
        // Ensure tabs use Bootstrap 5 attributes and panes are configured
        $response->assertSee('data-bs-toggle');
        $response->assertSee('tab-pane fade');
        $response->assertSee('show active');
        // Ensure tab fallback JS is present (simpler check to avoid test buffering issues)
        $response->assertSee('window.activateTabById');
    }

    public function test_edit_page_shows_form_and_updates_profile()
    {
        $user = User::factory()->create();

        // Visit edit page
        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('Actualizar información');
        $response->assertSee('Guardar cambios');
        $response->assertSee('Avatar');
        // Ensure file input exists (do not escape quotes when searching)
        $response->assertSee('type="file"', false);
        // Ensure the form is multipart for file uploads
        $response->assertSee('enctype="multipart/form-data"', false);

        // Update profile
        $payload = ['name' => 'Nuevo Nombre', 'email' => 'nuevo' . $user->id . '@example.com'];
        $response = $this->actingAs($user)->patch(route('profile.update'), $payload);
        $response->assertRedirect(route('profile'));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nuevo Nombre']);
    }

    public function test_ajustes_tab_shown_after_update()
    {
        $user = User::factory()->create();

        $payload = ['name' => 'Nombre Tab', 'email' => 'tab' . $user->id . '@example.com', 'active_tab' => 'ajustes'];
        $response = $this->actingAs($user)->patch(route('profile.update'), $payload);
        $response->assertRedirect(route('profile'));

        // follow-up request should render ajustes tab active
        $follow = $this->actingAs($user)->get(route('profile'));
        $follow->assertSee('id="tab-ajustes"', false);
        $follow->assertSee('id="ajustes"', false);
        $follow->assertSee('show active', false);
    }

    public function test_seguridad_tab_shown_after_password_change_and_on_error()
    {
        $user = User::factory()->create(['password' => bcrypt('old-password')]);

        // Successful password change should activate seguridad tab
        $payload = ['current_password' => 'old-password', 'password' => 'new-password', 'password_confirmation' => 'new-password', 'active_tab' => 'seguridad'];
        $response = $this->actingAs($user)->post(route('profile.password'), $payload);
        $response->assertSessionHas('active_tab', 'seguridad');

        // Simulate wrong current password and expect old input to preserve active_tab
        $bad = ['current_password' => 'wrong', 'password' => 'new-password-long', 'password_confirmation' => 'new-password-long', 'active_tab' => 'seguridad'];
        $response = $this->actingAs($user)->post(route('profile.password'), $bad);
        $response->assertSessionHasErrors('current_password');
        // Old input should preserve active_tab -> check session directly
        $this->assertEquals('seguridad', session('_old_input.active_tab'));

    }
}

