<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{
    public function index()
    {
        // Asegurar explícitamente que no incluimos registros eliminados
        $items = Proveedores::withoutTrashed()->orderBy('nombre')->paginate(20);
        return view('proveedores.index', compact('items'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string',
        ]);

        Proveedores::create($data);
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado.');
    }

    public function show(Proveedores $proveedor)
    {
        return view('proveedores.show', ['item' => $proveedor]);
    }

    public function edit(Proveedores $proveedor)
    {
        return view('proveedores.edit', ['item' => $proveedor]);
    }

    public function update(Request $request, Proveedores $proveedor)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($data);
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy($id)
    {
        // Resolver el proveedor explícitamente para evitar problemas con el binding
        \Illuminate\Support\Facades\Log::info('Destroy called for proveedor id param: '.$id);

        $proveedor = Proveedores::findOrFail($id);

        DB::transaction(function () use ($proveedor) {
            // Desvincular productos (proveedor_id = NULL) antes de soft-delete
            \Illuminate\Support\Facades\Log::info('Updating products for proveedor id: '.$proveedor->id);
            $proveedor->productos()->update(['proveedor_id' => null]);

            \Illuminate\Support\Facades\Log::info('Deleting proveedor id: '.$proveedor->id);
            $proveedor->delete();

            \Illuminate\Support\Facades\Log::info('After delete, proveedor deleted_at: '.$proveedor->fresh()->deleted_at);
        });

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado.');
    }

    public function eliminados()
    {
        $items = Proveedores::onlyTrashed()->paginate(20);
        return view('proveedores.eliminados', compact('items'));
    }

    public function restaurar($id)
    {
        $proveedor = Proveedores::onlyTrashed()->findOrFail($id);
        $proveedor->restore();
        return redirect()->route('proveedores.eliminados')->with('success', 'Proveedor restaurado.');
    }

    public function forzarEliminar($id)
    {
        $proveedor = Proveedores::onlyTrashed()->findOrFail($id);
        $proveedor->forceDelete();
        return redirect()->route('proveedores.eliminados')->with('success', 'Proveedor eliminado permanentemente.');
    }
}
