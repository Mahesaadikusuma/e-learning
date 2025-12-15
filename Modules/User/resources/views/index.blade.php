<x-layouts.app title="Users">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="" style="color: red;">Hello World</h1>
        <p class="text-blue-500 my-2">Module: {!! config('user.name') !!}</p>

        
        <x-flash-message class="my-2" />

        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default my-5">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">No.</th>
                        <th scope="col" class="px-6 py-3 font-medium">Name</th>
                        <th scope="col" class="px-6 py-3 font-medium">email</th>
                        <th scope="col" class="px-6 py-3 font-medium">Role</th>
                        <th scope="col" class="px-6 py-3 font-medium">Permission</th>
                        <th scope="col" class="px-6 py-3 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr class="bg-neutral-primary border-b border-default">
                            <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->getRoleNames()->implode(', ') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->getPermissionNames()->implode(', ') ?? 'N/A'  }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('user.edit', $user->id) }}" class="text-blue-600">
                                        Edit
                                    </a>
                                    <x-modal-delete 
                                        :id="$user->id"
                                        message="Are you sure delete permission"
                                        :item-name="$user->name"
                                        :route="route('user.destroy', $user->id)"
                                    />
                                </div>
                            </td>
                        </tr>        
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center">
                                No Data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.app>
