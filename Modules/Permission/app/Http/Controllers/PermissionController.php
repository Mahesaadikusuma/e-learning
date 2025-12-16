<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Modules\Permission\Services\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $perPage = 10;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
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

        $permissions = $this->permissionService->paginateFilteredPermissions($search, $orderBy, $this->perPage);
        return view('permission::index', [
            'permissions' => $permissions
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $orderBy = in_array($request->orderBy, ['asc', 'desc'])
            ? $request->orderBy
            : 'desc';

        $permissions = $this->permissionService->paginateFilteredPermissions($search, $orderBy, $this->perPage);
        return view('permission::index', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('permissions')->where(function ($query) use ($request) {
                        return $query->where('module', $request->module);
                    }),
                ],
                'module' => 'required',
            ]);

            $permission = $this->permissionService->createPermission($validate);
            return redirect()->route('permission.index')->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            ToastMagic::error("Failed to Create permission: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('permission::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permission::edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    Rule::unique('permissions')
                        ->ignore($permission->id)
                        ->where(function ($query) use ($request) {
                            return $query->where('module', $request->module);
                        }),
                ],
                'module' => 'required',
            ]);

            $permission = $this->permissionService->updatePermission($permission, $validated);
            return redirect()->route('permission.index')
                ->with('success', "Permission {$permission->name} updated successfully!");
        } catch (\Exception $e) {
            ToastMagic::error("Failed to Update permission: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $this->permissionService->deletePermission($permission);
            return redirect()->route('permission.index')
                ->with('success', "Permission {$permission->name} deleted successfully!");
        } catch (\Exception $e) {
            ToastMagic::error("Failed to delete permission: " . $e->getMessage());
            Log::info($e->getMessage());
            throw $e;
        }
    }
}
