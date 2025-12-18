<?php

namespace Modules\User\Services;

use App\Models\User;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Support\Facades\DB;
use Modules\Permission\Models\Permission;
use Modules\Roles\Models\Role;

class UserService
{
    public function getFilteredQueryUsers(?string $search = null, string $sortBy = 'desc')
    {
        return User::query()
            ->when($search, function ($q) use ($search) {
                $q->search($search);
            })
            ->orderBy('created_at', $sortBy);
    }

    public function paginateFilteredUsers(?string $search = null, string $sortBy = 'desc', $limit = 10)
    {
        return $this->getFilteredQueryUsers($search, $sortBy)->paginate($limit)->withQueryString();
    }

    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            // Update basic data
            $user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);

            // Update role (Spatie pakai name)
            $role = Role::where('uuid', $data['role'])->firstOrFail();
            $user->syncRoles([$role->name]);

            // Update permissions (direct permission)
            if (!empty($data['permissions'])) {
                $permissionNames = Permission::whereIn('uuid', $data['permissions'])
                    ->pluck('name')
                    ->toArray();

                $user->syncPermissions($permissionNames);
            } else {
                $user->syncPermissions([]);
            }

            ToastMagic::success("User {$user->name} updated successfully!");
            return $user;
        });
    }

    public function deleteUser(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Lepas semua role & permission (best practice Spatie)
            $user->syncRoles([]);
            $user->syncPermissions([]);

            // Hapus user
            $user->delete();
        });
    }
}
