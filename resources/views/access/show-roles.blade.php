@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    @can('show roles')
                        @can('create role')
                            <a href="{{ route('access.createRole') }}"
                                class="bg-transparent hover:bg-blue-500 dark:bg-blue-500 dark:text-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                {{ __('Create New Role') }}
                            </a>
                        @endcan
                        @include('access.partials.cards-roles')
                    @else
                        @include('layouts.danger-alert')
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
