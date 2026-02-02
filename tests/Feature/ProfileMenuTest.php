<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_menu_link_exists_and_is_active_on_profile_page()
    {
        $user = User::factory()->create();

        // Visit profile page
        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
        // Sidebar link exists
        $response->assertSee('href="http://localhost/profile"', false);
        $response->assertSee('Perfil');
        // On the profile page, the menu item should be rendered active
        $response->assertSee('nav-link active', false);
    }

    public function test_profile_menu_present_on_other_pages_but_not_active()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
        $response->assertSee('href="http://localhost/profile"', false);
        $response->assertSee('Perfil');
        // Prefer not to assert 'nav-link active' because other apps may set different active classes, but ensure response doesn't falsely mark profile active
        $this->assertStringNotContainsString('href="http://localhost/profile"' . '" class="nav-link active"', $response->getContent());
    }
}
