<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
        @foreach ($roles as $role)
            <a
                href="@can('assign permission to role') {{ route('access.assignPermissionToRole', ['id' => $role->id]) }} @else # @endcan">
                <div
                    class="flex items-center shadow hover:bg-indigo-100 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-105 p-3
                dark:bg-slate-200 cursor-pointer">
                    {{-- <img class="w-10 h-10 rounded-full mr-4" :src="`${item.profile_image}`" /> --}}
                    <div class="text-l">
                        <p class="text-gray-900 leading-none uppercase">
                            {{ $role->name }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
