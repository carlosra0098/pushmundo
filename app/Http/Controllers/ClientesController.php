<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientesController extends Controller
{
    /**
     * Mostrar lista de clientes
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Solo mostrar clientes no eliminados
            $clientes = Clientes::whereNull('deleted_at')->orderBy('nombre', 'asc')->paginate(15);
            return view('clientes.index', compact('clientes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar los clientes: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario para crear nuevo cliente
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar nuevo cliente en la base de datos
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validated = $request->validate([
                'nombre' => 'required|string|max:100|min:3',
                'apellido' => 'required|string|max:100|min:3',
                'email' => 'required|email|unique:clientes,email|max:100',
                'telefono' => 'required|regex:/^[\d\s\-\+\(\)]+$/|min:7|max:20',
                'direccion' => 'nullable|string|max:255',
            ], $this->getCustomMessages());

            // Crear el nuevo cliente
            Clientes::create($validated);

            return redirect()->route('clientes.index')
                            ->with('success', 'Cliente agregado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el cliente: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar formulario para editar cliente
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $cliente = Clientes::findOrFail($id);
            return view('clientes.edit', compact('cliente'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                            ->with('error', 'Cliente no encontrado.');
        }
    }

    /**
     * Actualizar cliente en la base de datos
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $cliente = Clientes::findOrFail($id);

            // Validar los datos de entrada
            $validated = $request->validate([
                'nombre' => 'required|string|max:100|min:3',
                'apellido' => 'required|string|max:100|min:3',
                'email' => 'required|email|max:100|unique:clientes,email,' . $id,
                'telefono' => 'required|regex:/^[\d\s\-\+\(\)]+$/|min:7|max:20',
                'direccion' => 'nullable|string|max:255',
            ], $this->getCustomMessages());

            // Actualizar el cliente
            $cliente->update($validated);

            return redirect()->route('clientes.index')
                            ->with('success', 'Cliente actualizado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                            ->with('error', 'Cliente no encontrado.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el cliente: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar cliente de la base de datos
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $cliente = Clientes::findOrFail($id);
            $nombreCliente = $cliente->nombre . ' ' . $cliente->apellido;

            $cliente->delete();

            return redirect()->route('clientes.index')
                            ->with('success', "Cliente '{$nombreCliente}' eliminado correctamente.");
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                            ->with('error', 'Cliente no encontrado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar lista de clientes eliminados
     *
     * @return \Illuminate\View\View
     */
    public function eliminados()
    {
        try {
            // Mostrar solo clientes eliminados
            $clientes = Clientes::onlyTrashed()->orderBy('nombre', 'asc')->paginate(15);
            return view('clientes.eliminados', compact('clientes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar los clientes eliminados: ' . $e->getMessage());
        }
    }

    /**
     * Restaurar cliente eliminado
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restaurar($id)
    {
        try {
            // Buscar cliente eliminado
            $cliente = Clientes::onlyTrashed()->findOrFail($id);
            
            // Restaurar cliente
            $cliente->restore();

            return redirect()->route('clientes.eliminados')
                            ->with('success', "Cliente '{$cliente->nombre_completo}' restaurado correctamente.");
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.eliminados')
                            ->with('error', 'Cliente no encontrado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al restaurar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar permanentemente cliente
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forzarEliminar($id)
    {
        try {
            // Buscar cliente eliminado (solo)
            $cliente = Clientes::onlyTrashed()->findOrFail($id);
            $nombreCliente = $cliente->nombre_completo;

            // Eliminar permanentemente
            $cliente->forceDelete();

            return redirect()->route('clientes.eliminados')
                            ->with('success', "Cliente '{$nombreCliente}' eliminado permanentemente.");
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.eliminados')
                            ->with('error', 'Cliente no encontrado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar permanentemente: ' . $e->getMessage());
        }
    }

    /**
     * Obtener mensajes de validación personalizados
     *
     * @return array
     */
    private function getCustomMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede exceder 100 caracteres.',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres.',
            
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Este email ya está registrado.',
            'email.max' => 'El email no puede exceder 100 caracteres.',
            
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono contiene caracteres inválidos.',
            'telefono.min' => 'El teléfono debe tener al menos 7 dígitos.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            
            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
        ];
    }
}
