<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403, 'Solo administradores.');

        $users = User::orderBy('id', 'desc')->paginate(15);

        return view('usuarios.index', compact('users'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403, 'Solo administradores.');

        $validated = $request->validate([
            'role' => 'required|in:admin,usuario',
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Rol actualizado correctamente.');
    }
}
