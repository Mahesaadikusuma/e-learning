<?php

namespace Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\RedirectResponse;
use Modules\Roles\Http\Requests\RoleStoreRequest;
use Modules\Roles\Http\Requests\RoleUpdateRequest;
use Modules\Roles\Services\RoleService;

class RolesController extends Controller
{
    protected $roleService;
    protected $perPage = 2;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;
        $orderBy = in_array($request->orderBy, ['asc', 'desc'])
            ? $request->orderBy
            : 'desc';
        $roles =  $this->roleService->paginateFilteredRoles($search, $orderBy, $this->perPage);
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
        $roles =  $this->roleService->paginateFilteredRoles($search, $orderBy, $this->perPage);

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
    public function store(RoleStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $role = $this->roleService->createRole($validated);
            return redirect()->route('roles.index')->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            ToastMagic::error("Failed to create role: " . $e->getMessage());
            throw $e;
        }
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
    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $this->roleService->updateRole($role, $validated);
            return redirect()->route('roles.index')
                ->with('success', "Role {$role->name} updated successfully!");
        } catch (\Exception $e) {
            ToastMagic::error("Failed to update role: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $this->roleService->deleteRole($role);
            return redirect()->route('roles.index')
                ->with('success', "Role {$role->name} deleted successfully!");
        } catch (\Exception $e) {
            ToastMagic::error("Failed to delete role: " . $e->getMessage());
            throw $e;
        }
    }
}
