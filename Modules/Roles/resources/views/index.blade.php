<x-layouts.app title="Roles">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="" style="color: red;">Hello World</h1>
        <p class="text-blue-500 my-2">Module: {!! config('roles.name') !!}</p>

        <a href="{{ route('roles.create') }}" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
            Create Role
        </a>

        <x-flash-message class="my-2" />

        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default my-5">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $key => $role)
                        <tr class="bg-neutral-primary border-b border-default">
                            <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $role->name }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="text-red-600">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                        class="text-white bg-danger box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3">
                                        Delete
                                    </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="2" class="px-6 py-4 text-center">
                            No Data
                        </td>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="">
            {{ $roles->links() }}
        </div>
    </div>
</x-layouts.app>
