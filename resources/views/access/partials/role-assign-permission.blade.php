<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <form action="{{ route('access.storePermissionToRole', ['id' => $role->id]) }}" method="post">
        @csrf
        <div class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($permissions as $per)
                <div>
                    <div class="flex items-center mb-4">
                        <input id="{{ str_replace(' ', '-', $per->name) }}" type="checkbox" value='{{ $per->name }}'
                            name="{{ str_replace(' ', '-', $per->name) . '-' . $per->id }}"
                            @foreach ($role->getAllPermissions() as $permission)
                                @if ($per->name == $permission->name)
                                    checked
                                @endif @endforeach
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{ str_replace(' ', '-', $per->name) }}"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $per->name }}</label>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>

    </form>
</div>
