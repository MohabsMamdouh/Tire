@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Route::currentRouteName() == 'user.edit' ? __('Update User') : __('Create New User') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @can(['update customer', 'create customer'])

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('customers.partials.customer-form')
                    </div>
                </div>

                @if (isset($customer))
                    @can('reset customer password')
                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('customers.partials.reset-password-form')
                            </div>
                        </div>
                    @endcan

                    @can('delete customer')
                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('customers.partials.delete-form')
                            </div>
                        </div>
                    @endcan
                @endif
            @else
                @include('layouts.danger-alert')
            @endcan


        </div>
    </div>
</x-app-layout>
