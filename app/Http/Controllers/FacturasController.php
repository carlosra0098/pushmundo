<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Clientes;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    public function index()
    {
        $items = Facturas::with('cliente')->orderBy('fecha','desc')->paginate(20);
        return view('facturas.index', compact('items'));
    }

    public function create()
    {
        $clientes = Clientes::pluck('nombre', 'id');
        return view('facturas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
        ]);

        Facturas::create($data);
        return redirect()->route('facturas.index')->with('success', 'Factura creada.');
    }

    public function show(Facturas $factura)
    {
        return view('facturas.show', ['item' => $factura]);
    }

    public function edit(Facturas $factura)
    {
        $clientes = Clientes::pluck('nombre', 'id');
        return view('facturas.edit', ['item' => $factura, 'clientes' => $clientes]);
    }

    public function update(Request $request, Facturas $factura)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'comentarios' => 'nullable|string',
        ]);

        $factura->update($data);
        return redirect()->route('facturas.index')->with('success', 'Factura actualizada.');
    }

    public function destroy(Facturas $factura)
    {
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
        $factura = Facturas::onlyTrashed()->findOrFail($id);
        $factura->forceDelete();
        return redirect()->route('facturas.eliminados')->with('success', 'Factura eliminada permanentemente.');
    }
}
