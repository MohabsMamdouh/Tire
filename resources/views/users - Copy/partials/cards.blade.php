<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
        @foreach ($users as $user)
            <a href="@can('update user')  {{ route('user.ShowSingle', ['id' => $user->id]) }} @else # @endcan">
                <div
                    class="flex items-center shadow hover:bg-indigo-100 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-105 p-3
                  dark:bg-slate-200 cursor-pointer">
                    {{-- <img class="w-10 h-10 rounded-full mr-4" :src="`${item.profile_image}`" /> --}}
                    <div class="text-l">
                        <p class="text-gray-900 leading-none">
                            {{ $user->fname }} => [{{ count($user->visits) }}]
                        </p>
                        <p class="text-gray-600">{{ $user->username }}</p>
                        {{-- {{ dd($user->roles[0]->name) }} --}}
                        <p class="text-gray-600">
                            <b>
                                @isset($user->roles[0])
                                    {{ $user->roles[0]->name }}
                                @endisset
                            </b>
                        </p>
                        <p class="text-gray-600">{{ $user->phone }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
