<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        $items = Productos::with('proveedor')->orderBy('nombre')->paginate(20);
        return view('productos.index', compact('items'));
    }

    public function create()
    {
        $proveedores = Proveedores::pluck('nombre', 'id');
        return view('productos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'stock' => 'nullable|integer',
        ]);

        Productos::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado.');
    }

    public function show(Productos $producto)
    {
        return view('productos.show', ['item' => $producto]);
    }

    public function edit(Productos $producto)
    {
        $proveedores = Proveedores::pluck('nombre', 'id');
        return view('productos.edit', ['item' => $producto, 'proveedores' => $proveedores]);
    }

    public function update(Request $request, Productos $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'stock' => 'nullable|integer',
        ]);

        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Productos $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }

    public function eliminados()
    {
        $items = Productos::onlyTrashed()->with('proveedor')->paginate(20);
        return view('productos.eliminados', compact('items'));
    }

    public function restaurar($id)
    {
        $producto = Productos::onlyTrashed()->findOrFail($id);
        $producto->restore();
        return redirect()->route('productos.eliminados')->with('success', 'Producto restaurado.');
    }

    public function forzarEliminar($id)
    {
        $producto = Productos::onlyTrashed()->findOrFail($id);
        $producto->forceDelete();
        return redirect()->route('productos.eliminados')->with('success', 'Producto eliminado permanentemente.');
    }
}
