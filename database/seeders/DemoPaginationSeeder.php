<?php

namespace Database\Seeders;

use App\Models\Clientes;
use App\Models\Empleados;
use App\Models\Facturas;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoPaginationSeeder extends Seeder
{
    /**
     * Seed large demo data for pagination checks.
     */
    public function run(): void
    {
        $this->seedUsers();
        $clientes = $this->seedClientes(80);
        $proveedores = $this->seedProveedores(60);
        $this->seedProductos(120, $proveedores);
        $this->seedEmpleados(70);
        $this->seedFacturas(130, $clientes);
    }

    private function seedUsers(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador Principal',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'usuario@demo.com'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('Usuario12345!'),
                'role' => 'usuario',
            ]
        );

        for ($i = 1; $i <= 30; $i++) {
            User::updateOrCreate(
                ['email' => "demo{$i}@mail.com"],
                [
                    'name' => "Demo Usuario {$i}",
                    'password' => Hash::make('Demo12345!'),
                    'role' => $i % 8 === 0 ? 'admin' : 'usuario',
                ]
            );
        }
    }

    private function seedClientes(int $total): array
    {
        $ids = [];

        for ($i = 1; $i <= $total; $i++) {
            $cliente = Clientes::updateOrCreate(
                ['email' => "cliente{$i}@mail.com"],
                [
                    'nombre' => "Cliente{$i}",
                    'apellido' => "Apellido{$i}",
                    'telefono' => '600000' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'direccion' => "Calle Demo {$i}, Ciudad",
                ]
            );

            $ids[] = $cliente->id;
        }

        return $ids;
    }

    private function seedProveedores(int $total): array
    {
        $ids = [];

        for ($i = 1; $i <= $total; $i++) {
            $proveedor = Proveedores::updateOrCreate(
                ['nombre' => "Proveedor {$i}"],
                [
                    'contacto' => "Contacto {$i}",
                    'telefono' => '700000' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'direccion' => "Avenida Proveedor {$i}",
                ]
            );

            $ids[] = $proveedor->id;
        }

        return $ids;
    }

    private function seedProductos(int $total, array $proveedorIds): void
    {
        $proveedorCount = count($proveedorIds);

        for ($i = 1; $i <= $total; $i++) {
            Productos::updateOrCreate(
                ['codigo' => 'PRD-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT)],
                [
                    'nombre' => "Producto {$i}",
                    'descripcion' => "Descripción del producto {$i}",
                    'precio' => rand(10, 900) + 0.99,
                    'proveedor_id' => $proveedorCount > 0 ? $proveedorIds[$i % $proveedorCount] : null,
                    'stock' => rand(1, 400),
                ]
            );
        }
    }

    private function seedEmpleados(int $total): void
    {
        $puestos = ['Vendedor', 'Supervisor', 'Almacén', 'Atención', 'Administrativo'];

        for ($i = 1; $i <= $total; $i++) {
            Empleados::updateOrCreate(
                ['email' => "empleado{$i}@mail.com"],
                [
                    'nombre' => "Empleado{$i}",
                    'apellido' => "Apellido{$i}",
                    'telefono' => '650000' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'puesto' => $puestos[$i % count($puestos)],
                ]
            );
        }
    }

    private function seedFacturas(int $total, array $clienteIds): void
    {
        $clienteCount = count($clienteIds);

        if ($clienteCount === 0) {
            return;
        }

        for ($i = 1; $i <= $total; $i++) {
            $numero = 'FAC-' . str_pad((string) $i, 5, '0', STR_PAD_LEFT);

            Facturas::updateOrCreate(
                ['numero' => $numero],
                [
                    'cliente_id' => $clienteIds[$i % $clienteCount],
                    'fecha' => now()->subDays($i)->toDateString(),
                    'total' => rand(50, 2500) + 0.50,
                    'estado' => $i % 3 === 0 ? 'pagada' : 'pendiente',
                    'comentarios' => "Factura de prueba {$i}",
                ]
            );
        }
    }
}
