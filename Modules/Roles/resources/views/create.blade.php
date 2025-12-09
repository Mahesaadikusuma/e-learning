<x-layouts.app title="Create Role">
    <div class="flex flex-col items-center justify-center min-h-screen">
    <h1 class="text-center font-bold text-2xl mb-5">Create Roles</h1>
    <div class="w-full max-w-md">
        <x-validation-errors class="mb-4" />
    </div>
    
    <div class="w-full max-w-md bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <h5 class="text-xl font-semibold text-heading mb-6">Create Role User</h5>
            <div class="mb-4">
                <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Name Roles</label>
                <input type="name" id="name" name="name"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="Admin" required />
            </div>

            <button type="submit"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3">
                Create Role
            </button>
        </form>
    </div>
</div>
</x-layouts.app>
