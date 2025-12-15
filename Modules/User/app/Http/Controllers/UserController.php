<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles', 'permissions'])->paginate(10);
        return view('user::index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        $roles = Role::all();
        return view('user::edit', [
            'user' => $user,
            'permissions' => $permissions,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('users', 'name')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);
        $user = User::findOrFail($id);
        // $user->update($validated);
        $role = Role::findOrFail($validated['role']);
        $user->syncRoles([$role->name]); // ✅ Spatie pakai name untuk syncRoles

        // Sync direct permissions
        if (isset($validated['permissions'])) {
            // Ambil nama permission berdasarkan ID
            $permissionNames = Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray();
            $user->syncPermissions($permissionNames);
        } else {
            $user->syncPermissions([]);
        }


        return redirect()->route('user.index')
            ->with('success', "User {$user->name} updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
