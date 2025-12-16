<?php

namespace Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $orderBy = in_array($request->orderBy, ['asc', 'desc'])
            ? $request->orderBy
            : 'desc';

        $roles = Role::query()
            ->when(
                $search,
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->orderBy('id', $orderBy)
            ->paginate(2)
            ->withQueryString();
        return view('roles::index', [
            'roles' => $roles
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $orderBy = in_array($request->orderBy, ['asc', 'desc'])
            ? $request->orderBy
            : 'desc';

        $roles = Role::query()
            ->when(
                $search,
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->orderBy('id', $orderBy)
            ->paginate(2)
            ->withQueryString();

        return view('roles::index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:roles,name',
        ]);
        $role = Role::create($validated);
        ToastMagic::success("Role created successfully!");
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('roles::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles::edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($id),
            ]
        ]);

        $role->update($validated);
        ToastMagic::success("Role {$role->name} updated successfully!");
        return redirect()->route('roles.index')
            ->with('success', "Role {$role->name} updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        ToastMagic::success("Role {$role->name} deleted successfully!");
        return redirect()->route('roles.index')
            ->with('success', "Role {$role->name} deleted successfully!");
    }
}
