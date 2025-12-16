<?php

namespace Modules\Roles\Services;

use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Request;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class RoleService
{
    public function getFilteredQueryRoles(?string $search = null, string $sortBy = 'desc')
    {
        return Role::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', $sortBy);
    }


    public function paginateFilteredRoles(?string $search = null, string $sortBy = 'desc', $limit = 10)
    {
        return $this->getFilteredQueryRoles($search, $sortBy)->paginate($limit)->withQueryString();
    }

    public function createRole(array $data)
    {
        $role = Role::create($data);
        ToastMagic::success("Role created successfully!");
        return $role;
    }

    public function updateRole(Role $role, array $data)
    {
        $role->update($data);
        ToastMagic::success("Role updated successfully!");
        return $role;
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        ToastMagic::success("Role deleted successfully!");
    }
}
