@extends('customer.layouts.app')

@section('header')
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-10">
                        <a href="{{ route('customer.cars.create') }}"
                            class="bg-transparent hover:bg-blue-500 dark:bg-blue-500 dark:text-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                            {{ __('Add Car') }}
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($cars as $car)
                            <div
                                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $car->car_name }}
                                </h5>
                                <div class="font-normal text-gray-700 dark:text-gray-400">
                                    <div class="grid grid-rows-4 ">
                                        <p class="row-span-1 text-gray-600 dark:text-gray-200">{{ $car->model }}</p>
                                        <p class="row-span-2 text-gray-600 dark:text-gray-200">
                                            <b>{{ __('Drive: ') }}</b> {{ $car->drive }}<br>
                                            <b>{{ __('Cylinders: ') }}</b> {{ $car->cylinders }}<br>
                                            <b>{{ __('Eng_dscr: ') }}</b> {{ $car->eng_dscr }}<br>
                                            <b>{{ __('Fueltype: ') }}</b> {{ $car->fueltype }}<br>
                                            <b>{{ __('Fueltype1: ') }}</b> {{ $car->fueltype1 }}<br>
                                            <b>{{ __('Mpgdata: ') }}</b> {{ $car->mpgdata }}<br>
                                        </p>
                                        <div class="row-span-1 relative">
                                            <a href="{{ route('customer.cars.destroy', ['model_id' => $car->model_id]) }}"
                                                class="absolute bottom-0 right-0 bg-transparent hover:bg-red-500 dark:bg-red-500 dark:text-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">
                                                {{ __('Delete Car') }}
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
