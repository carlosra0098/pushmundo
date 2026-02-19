<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FacturasController extends Controller
{
    public function index()
    {
        $items = Facturas::with('cliente')->orderBy('fecha','desc')->paginate(20);
        return view('facturas.index', compact('items'));
    }

    public function create()
    {
        $clientes = Clientes::select('id', 'nombre', 'apellido')
            ->orderBy('nombre')
            ->get();

        return view('facturas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:100|unique:facturas,numero',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:100',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'comentarios' => 'nullable|string',
        ], [
            'archivo_pdf.mimes' => 'El archivo de factura debe ser un PDF válido.',
            'archivo_pdf.max' => 'El PDF de factura no puede superar 5MB.',
        ]);

        if ($request->hasFile('archivo_pdf')) {
            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('facturas/pdfs', 'public');
        }

        Facturas::create($data);
        return redirect()->route('facturas.index')->with('success', 'Factura creada.');
    }

    public function show(Facturas $factura)
    {
        return view('facturas.show', ['item' => $factura]);
    }

    public function edit(Facturas $factura)
    {
        $clientes = Clientes::select('id', 'nombre', 'apellido')
            ->orderBy('nombre')
            ->get();

        return view('facturas.edit', ['item' => $factura, 'clientes' => $clientes]);
    }

    public function update(Request $request, Facturas $factura)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:100|unique:facturas,numero,' . $factura->id,
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:100',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'comentarios' => 'nullable|string',
        ], [
            'archivo_pdf.mimes' => 'El archivo de factura debe ser un PDF válido.',
            'archivo_pdf.max' => 'El PDF de factura no puede superar 5MB.',
        ]);

        if ($request->hasFile('archivo_pdf')) {
            if (!empty($factura->archivo_pdf)) {
                $oldPath = ltrim((string) $factura->archivo_pdf, '/');

                if (str_starts_with($oldPath, 'storage/')) {
                    $oldPath = substr($oldPath, 8);
                }

                if (str_starts_with($oldPath, 'public/')) {
                    $oldPath = substr($oldPath, 7);
                }

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('facturas/pdfs', 'public');
        }

        $factura->update($data);
        return redirect()->route('facturas.index')->with('success', 'Factura actualizada.');
    }

    public function destroy(Facturas $factura)
    {
        if (auth()->check() && Gate::denies('delete-records')) {
            abort(403, 'No tienes permisos para eliminar.');
        }

        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada.');
    }

    public function eliminados()
    {
        $items = Facturas::onlyTrashed()->with('cliente')->paginate(20);
        return view('facturas.eliminados', compact('items'));
    }

    public function restaurar($id)
    {
        $factura = Facturas::onlyTrashed()->findOrFail($id);
        $factura->restore();
        return redirect()->route('facturas.eliminados')->with('success', 'Factura restaurada.');
    }

    public function forzarEliminar($id)
    {
        if (auth()->check() && Gate::denies('delete-records')) {
            abort(403, 'No tienes permisos para eliminar.');
        }

        $factura = Facturas::onlyTrashed()->findOrFail($id);

        if (!empty($factura->archivo_pdf)) {
            $oldPath = ltrim((string) $factura->archivo_pdf, '/');

            if (str_starts_with($oldPath, 'storage/')) {
                $oldPath = substr($oldPath, 8);
            }

            if (str_starts_with($oldPath, 'public/')) {
                $oldPath = substr($oldPath, 7);
            }

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $factura->forceDelete();
        return redirect()->route('facturas.eliminados')->with('success', 'Factura eliminada permanentemente.');
    }
}
