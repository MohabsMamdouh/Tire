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
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Add Car') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Add a new car to your list.') }}
                    </p>
                </header>


                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-3">
                        <form method="post" class="mt-6 space-y-6" action="{{ route('customer.cars.store') }}">
                            @csrf
                            {{-- Cars --}}
                            <div>
                                <x-input-label for="cars" :value="__('Car')" />
                                <select name="cars" id="cars"
                                    class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">-- {{ __('Chooce The Role') }} --</option>
                                    @foreach ($cars as $car)
                                        <option value="{{ $car->car_name }}">
                                            {{ $car->car_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cars')
                                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Models --}}
                            <div>
                                <x-input-label for="models" :value="__('Model')" />
                                <select name="models" id="models"
                                    class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">-- {{ __('Chooce The Model') }} --</option>

                                </select>
                                @error('models')
                                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>


                        </form>
                    </div>
                    <div class="col-span-2 mt-16 ml-10">
                        <div class="max-w-sm rounded overflow-hidden dark:bg-gray-400 shadow-lg hidden" id="specs">
                            <div class="px-6 py-4" id="car_info">

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {

                        function fetch_customer_data(query = '') {
                            $.ajax({
                                url: "{{ route('customer.cars.getCarModels') }}",
                                method: 'GET',
                                data: {
                                    query: query
                                },
                                success: function(data) {
                                    $('#models').html(data);
                                }
                            });
                        }

                        function fetch_car_data(model = '') {
                            $.ajax({
                                url: "{{ route('customer.cars.getCarSpecs') }}",
                                method: 'GET',
                                data: {
                                    model: model
                                },
                                success: function(data) {
                                    $('#car_info').html(data);
                                    console.log(data);
                                },

                            });
                        }


                        $('#cars').on('change', function() {
                            var query = $(this).val();
                            fetch_customer_data(query);
                        });

                        $('#models').on('change', function() {
                            $('#specs').removeClass('hidden');
                            var model = $(this).val();
                            fetch_car_data(model);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
