<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Facturas;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $stats = [
            'clientes' => Clientes::count(),
            'productos' => Productos::count(),
            'facturas' => Facturas::count(),
        ];

        return view('profile.show', compact('user', 'stats'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');

            // Delete old avatar if present
            if (! empty($user->avatar)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
                } catch (\Exception $e) {
                    // ignore
                }
            }

            $user->avatar = $path;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        // Ensure the Ajustes tab is active after successful update
        return redirect()->route('profile')->with('success', 'Perfil actualizado.')->with('active_tab', 'ajustes');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            // Preserve the seguridad tab on error so the user sees the form
            return back()->withErrors(['current_password' => 'La contraseña actual no coincide.'])->withInput(['active_tab' => 'seguridad']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada.')->with('active_tab', 'seguridad');
    }
}
