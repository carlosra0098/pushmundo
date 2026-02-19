<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
            'imagen' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:3072',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'precio' => 'nullable|numeric',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'stock' => 'nullable|integer',
            'codigo' => 'nullable|string|max:50|unique:productos,codigo',
        ], [
            'imagen.mimes' => 'La imagen debe estar en formato JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar 3MB.',
            'archivo_pdf.mimes' => 'El archivo debe ser un PDF válido.',
            'archivo_pdf.max' => 'El PDF no puede superar 5MB.',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos/imagenes', 'public');
        }

        if ($request->hasFile('archivo_pdf')) {
            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('productos/pdfs', 'public');
        }

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
            'imagen' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:3072',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'precio' => 'nullable|numeric',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'stock' => 'nullable|integer',
            'codigo' => 'nullable|string|max:50|unique:productos,codigo,' . $producto->id,
        ], [
            'imagen.mimes' => 'La imagen debe estar en formato JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar 3MB.',
            'archivo_pdf.mimes' => 'El archivo debe ser un PDF válido.',
            'archivo_pdf.max' => 'El PDF no puede superar 5MB.',
        ]);

        if ($request->hasFile('imagen')) {
            if (!empty($producto->imagen)) {
                $oldImagePath = ltrim((string) $producto->imagen, '/');

                if (str_starts_with($oldImagePath, 'storage/')) {
                    $oldImagePath = substr($oldImagePath, 8);
                }

                if (str_starts_with($oldImagePath, 'public/')) {
                    $oldImagePath = substr($oldImagePath, 7);
                }

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $data['imagen'] = $request->file('imagen')->store('productos/imagenes', 'public');
        }

        if ($request->hasFile('archivo_pdf')) {
            if (!empty($producto->archivo_pdf)) {
                $oldPdfPath = ltrim((string) $producto->archivo_pdf, '/');

                if (str_starts_with($oldPdfPath, 'storage/')) {
                    $oldPdfPath = substr($oldPdfPath, 8);
                }

                if (str_starts_with($oldPdfPath, 'public/')) {
                    $oldPdfPath = substr($oldPdfPath, 7);
                }

                if (Storage::disk('public')->exists($oldPdfPath)) {
                    Storage::disk('public')->delete($oldPdfPath);
                }
            }

            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('productos/pdfs', 'public');
        }

        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Productos $producto)
    {
        if (auth()->check() && Gate::denies('delete-records')) {
            abort(403, 'No tienes permisos para eliminar.');
        }

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
        if (auth()->check() && Gate::denies('delete-records')) {
            abort(403, 'No tienes permisos para eliminar.');
        }

        $producto = Productos::onlyTrashed()->findOrFail($id);

        if (!empty($producto->imagen) && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        if (!empty($producto->archivo_pdf) && Storage::disk('public')->exists($producto->archivo_pdf)) {
            Storage::disk('public')->delete($producto->archivo_pdf);
        }

        $producto->forceDelete();
        return redirect()->route('productos.eliminados')->with('success', 'Producto eliminado permanentemente.');
    }
}
