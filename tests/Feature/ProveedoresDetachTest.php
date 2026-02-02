<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Proveedores;
use App\Models\Productos;

class ProveedoresDetachTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleted_proveedor_not_listed_and_products_detached()
    {
        // Crear proveedor y producto asociado
        $prov = Proveedores::create(['nombre' => 'ToRemove']);

        $prod = Productos::create([
            'nombre' => 'ProdForProv',
            'precio' => 10,
            'stock' => 5,
            'proveedor_id' => $prov->id,
        ]);

        // Llamar la ruta destroy (HTTP DELETE)
        $response = $this->delete(route('proveedores.destroy', $prov));
        $response->assertRedirect(route('proveedores.index'));

        // La lista no debe mostrar el proveedor eliminado
        $this->assertDatabaseHas('proveedores', ['id' => $prov->id]);
        $this->assertNotNull(\App\Models\Proveedores::withTrashed()->find($prov->id)->deleted_at);

        // Comprobar que la consulta Eloquent excluye el proveedor
        $this->assertFalse(\App\Models\Proveedores::orderBy('nombre')->get()->pluck('nombre')->contains('ToRemove'));

        // La vista index tampoco debe mostrarlo
        $listResponse = $this->get(route('proveedores.index'));
        $listResponse->assertDontSee('ToRemove');

        // El producto debe quedar con proveedor_id NULL
        $this->assertDatabaseHas('productos', [
            'id' => $prod->id,
            'proveedor_id' => null,
        ]);
    }
}
