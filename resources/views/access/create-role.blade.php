@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @can('create role')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        {{-- @include('access.partials.role-form') --}}
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Create New Role') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Create New Role.') }}
                                </p>
                            </header>

                            <form method="post" class="mt-6 space-y-6" action="{{ route('access.storeRole') }}">
                                @csrf

                                {{-- Role Name --}}
                                <div>
                                    <x-input-label for="role_name" :value="__('Role Name')" />
                                    <x-text-input id="role_name" name="role_name" type="text" class="mt-1 block w-full"
                                        required autofocus autocomplete="role_name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('role_name')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>


                            </form>

                        </section>

                    </div>
                </div>
            @else
                @include('layouts.danger-alert')
            @endcan


        </div>
    </div>
</x-app-layout>
