<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UiSpacingTest extends TestCase
{
    use RefreshDatabase;

    public function test_proveedores_index_has_crm_card()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('proveedores.index'));
        $response->assertStatus(200);
        $response->assertSee('crm-card');
        $response->assertSee('container-fluid');
    }

    public function test_productos_index_has_crm_card()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('productos.index'));
        $response->assertStatus(200);
        $response->assertSee('crm-card');
    }

    public function test_clientes_create_has_container_fluid()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('clientes.create'));
        $response->assertStatus(200);
        $response->assertSee('container-fluid');
    }
}
