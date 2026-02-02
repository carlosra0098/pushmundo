<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    public function index()
    {
        $items = Empleados::orderBy('nombre')->paginate(20);
        return view('empleados.index', compact('items'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255', // Añadido el campo apellido
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'puesto' => 'nullable|string|max:255',
        ]);

        Empleados::create($data);
        return redirect()->route('empleados.index')->with('success', 'Empleado creado.');
    }

    public function show(Empleados $empleado)
    {
        return view('empleados.show', ['item' => $empleado]);
    }

    public function edit(Empleados $empleado)
    {
        return view('empleados.edit', ['item' => $empleado]);
    }

    public function update(Request $request, Empleados $empleado)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255', // Añadido el campo apellido
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'puesto' => 'nullable|string|max:255',
        ]);

        $empleado->update($data);
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado.');
    }

    public function destroy(Empleados $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
    }

    public function eliminados()
    {
        $items = Empleados::onlyTrashed()->paginate(20);
        return view('empleados.eliminados', compact('items'));
    }

    public function restaurar($id)
    {
        $empleado = Empleados::onlyTrashed()->findOrFail($id);
        $empleado->restore();
        return redirect()->route('empleados.eliminados')->with('success', 'Empleado restaurado.');
    }

    public function forzarEliminar($id)
    {
        $empleado = Empleados::onlyTrashed()->findOrFail($id);
        $empleado->forceDelete();
        return redirect()->route('empleados.eliminados')->with('success', 'Empleado eliminado permanentemente.');
    }
}
