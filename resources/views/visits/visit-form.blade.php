@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Route::currentRouteName() == 'visit.create' ? __('Create Visit') : __('Edit Visit') }}

            {{-- {{ __('Create Visit') }} --}}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('visits.partials.form')
            </div>
            @if (Route::currentRouteName() == 'visit.edit')
                @can('delete visit')
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('visits.partials.delete-form')
                        </div>
                    </div>
                @endcan
            @endif

        </div>
    </div>
</x-app-layout>
