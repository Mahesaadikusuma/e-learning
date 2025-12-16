<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class PermissionController extends Controller
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

        $permissions = Permission::query()
            ->when(
                $search,
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->orderBy('id', $orderBy)
            ->paginate(10)
            ->withQueryString();
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

        $permissions = Permission::query()
            ->when(
                $search,
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->orderBy('id', $orderBy)
            ->paginate(10)
            ->withQueryString();

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
        $validate = $request->validate([
            'name' => [
                'required',
                Rule::unique('permissions')->where(function ($query) use ($request) {
                    return $query->where('module', $request->module);
                }),
            ],
            'module' => 'required',
        ]);

        $permission = Permission::create($validate);
        ToastMagic::success('Permission created successfully!');

        return redirect()->route('permission.index')->with('success', 'Permission created successfully');
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
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
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
        $permission->update($validated);
        ToastMagic::success("Permission {$permission->name} updated successfully!");

        return redirect()->route('permission.index')
            ->with('success', "Permission {$permission->name} updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::find($id);
            $permission->delete();
            ToastMagic::success("Permission {$permission->name} deleted successfully!");
            return redirect()->route('permission.index')
                ->with('success', "Permission {$permission->name} deleted successfully!");
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            throw $e;
        }
    }
}
