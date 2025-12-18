<x-layouts.app title="Update User">
    <div class="flex flex-col items-center justify-center min-h-screen">
    <h1 class="text-center font-bold text-2xl mb-5">Update User</h1>
    <div class="w-full max-w-md">
        <x-validation-errors class="mb-4" />
    </div>
    
    <div class="w-full max-w-md bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf
            <h5 class="text-xl font-semibold text-heading mb-6">Update User</h5>
            <div class="mb-4">
                <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                <input type="name" value="{{ $user->name }}" id="name" name="name"
                    class="bg-neutral-secondary-medium border cursor-not-allowed border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="" readonly />
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Email</label>
                <input type="email" value="{{ $user->email }}" id="email" name="email"
                    class="bg-neutral-secondary-medium border cursor-not-allowed border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="" readonly />
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-2.5 text-sm font-medium text-heading">Role</label>
                <select id="role" name="role" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option value="" selected>Select an option Role User</option>
                    @foreach ($roles as $role)
                    {{-- {{ $permission->module === $status->value ? 'selected' : '' }} --}}
                        <option value="{{ $role->uuid }}"@selected(old('role', $user->roles->first()?->uuid) == $role->uuid)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-2.5 text-sm font-medium text-heading">Permission</label>
                <div class="">
                    @foreach ($permissions as $permission)
                    <div class="flex items-center p-2 hover:bg-neutral-tertiary rounded cursor-pointer">
                        <input 
                            id="permission-{{ $permission->uuid }}" 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->uuid }}"
                            @checked(in_array($permission->uuid, old('permissions', $user->permissions->pluck('uuid')->toArray())))
                            class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand"
                        />
                        <label 
                            for="permission-{{ $permission->uuid }}" 
                            class="select-none ms-2 text-sm font-medium text-body cursor-pointer"
                        >
                            {{ $permission->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            
            
            <button type="submit"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3">
                Update User
            </button>
        </form>
    </div>
</div>
</x-layouts.app>
