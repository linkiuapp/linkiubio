<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\User;
use App\Shared\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query()->with('store');

        // Filtro por rol
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Búsqueda por nombre o email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ordenar por más reciente
        $users = $query->latest()->paginate(20);

        // Estadísticas
        $totalUsers = User::count();
        $superAdmins = User::where('role', 'super_admin')->count();
        $storeAdmins = User::where('role', 'store_admin')->count();
        $regularUsers = User::where('role', 'user')->count();

        return view('superlinkiu::user-management.index', compact(
            'users',
            'totalUsers',
            'superAdmins',
            'storeAdmins',
            'regularUsers'
        ));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $stores = Store::where('approval_status', 'approved')
            ->orderBy('name')
            ->get();

        return view('superlinkiu::user-management.create', compact('stores'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:super_admin,store_admin,user'],
            'store_id' => ['nullable', 'exists:stores,id', 'required_if:role,store_admin'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'store_id' => $request->role === 'store_admin' ? $request->store_id : null,
        ]);

        return redirect()
            ->route('superlinkiu.user-management.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $stores = Store::where('approval_status', 'approved')
            ->orderBy('name')
            ->get();

        return view('superlinkiu::user-management.edit', compact('user', 'stores'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:super_admin,store_admin,user'],
            'store_id' => ['nullable', 'exists:stores,id', 'required_if:role,store_admin'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'store_id' => $request->role === 'store_admin' ? $request->store_id : null,
        ];

        // Solo actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('superlinkiu.user-management.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevenir eliminar al propio usuario
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Prevenir eliminar el único super admin
        if ($user->role === 'super_admin' && User::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'No puedes eliminar el único Super Administrador.');
        }

        $user->delete();

        return redirect()
            ->route('superlinkiu.user-management.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}

