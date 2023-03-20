@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Route::currentRouteName() == 'feed.showAll' ? __('Show Accepted Feedbacks') : __('Create New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @can('create feedback')
                                <a href="{{ route('feed.create') }}"
                                    class="bg-transparent hover:bg-blue-500 dark:bg-blue-500 dark:text-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                    {{ __('Add New Feedback') }}
                                </a>
                            @endcan

                            @can('accept feedbacks')
                                <a href="{{ Route::currentRouteName() == 'feed.showAll' ? route('feed.show_accept') : route('feed.showAll') }}"
                                    class="bg-transparent hover:bg-green-500 dark:bg-green-500 dark:text-white text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                                    {{ Route::currentRouteName() == 'feed.showAll' ? __('Show None Accepted Feedbacks') : __('Show Accepted Feedbacks') }}
                                </a>
                            @endcan

                        </div>
                    </div>
                    @include('feedbacks.partials.cards')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
