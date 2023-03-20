<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ Route::currentRouteName() == 'visit.edit' ? __('Update Visit') : __('Create New Visit') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update or Add Visit Information.') }}
        </p>
    </header>


    <div class="grid grid-cols-6 gap-3">
        <div class="col-span-3">
            <form method="post" class="mt-6 space-y-6"
                action="{{ Route::currentRouteName() == 'visit.edit' ? route('visit.update', ['id' => $visit->id]) : route('visit.store') }}">
                @csrf

                {{-- Customer Name --}}
                <div>
                    <x-input-label for="customer_fname" :value="__('Customer Name')" />
                    @if (isset($visit))
                        <x-text-input id="customer_fname" list="customersList" name="customer_fname" type="text"
                            class="mt-1 block w-full" value="{{ $visit->customer->customer_fname }}" required autofocus
                            autocomplete="customer_fname" />
                    @else
                        <x-text-input id="customer_fname" list="customersList" name="customer_fname" type="text"
                            aria-placeholder="Customer Name ......" class="mt-1 block w-full" required autofocus
                            autocomplete="customer_fname" />
                    @endif
                    <datalist id="customersList">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_fname }}">{{ $customer->customer_fname }}</option>
                        @endforeach
                    </datalist>

                    @error('customer_fname')
                        <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Cars --}}
                <div>
                    <x-input-label for="cars" :value="__('Car')" />
                    <select name="cars" id="cars" required
                        class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        <option value="">-- {{ __('Chooce Customer Car') }} --</option>

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
                    <select name="models" id="models" required
                        class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        <option value="">-- {{ __('Chooce The Model') }} --</option>

                    </select>
                    @error('models')
                        <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Reason --}}
                <div>
                    <x-input-label for="reason" :value="__('Reason')" />
                    @if (isset($visit))
                        <x-text-input id="reason" list="ReasonList" name="reason" type="text"
                            class="mt-1 block w-full" value="{{ $visit->reason }}" required autofocus
                            autocomplete="reason" />
                    @else
                        <x-text-input id="reason" list="ReasonList" name="reason" type="text"
                            aria-placeholder="Reason ......" class="mt-1 block w-full" required autofocus
                            autocomplete="reason" />
                    @endif
                    <datalist id="ReasonList">
                        <option value="Checkup">{{ 'Checkup' }}</option>
                    </datalist>

                    @error('reason')
                        <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @role('super_admin')
                    {{-- Stuff Name --}}
                    <div>
                        <x-input-label for="stuff" :value="__('Stuff Name')" />
                        @if (isset($visit))
                            <x-text-input id="stuff" list="usersList" name="stuff" type="text"
                                class="mt-1 block w-full" value="{{ $visit->user->fname }}" required autofocus
                                autocomplete="stuff" />
                        @else
                            <x-text-input id="stuff" list="usersList" name="stuff" type="text"
                                aria-placeholder="Stuff ......" class="mt-1 block w-full" required autofocus
                                autocomplete="stuff" />
                        @endif
                        <datalist id="usersList">
                            @foreach ($users as $user)
                                <option value="{{ $user->fname }}">{{ $user->fname }}</option>
                            @endforeach
                        </datalist>

                        @error('stuff')
                            <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endrole


                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </div>
        <div class="col-span-2 mt-16 ml-10">
            <div class="max-w-sm rounded overflow-hidden dark:bg-gray-400 shadow-lg @if (!isset($visit)) hidden @endif"
                id="specs">
                <div class="px-6 py-4" id="car_info">
                    @if (isset($visit))
                        <div class="font-bold text-xl mb-2">

                            @foreach ($cars as $car)
                                @foreach ($car->models as $model)
                                    @if ($model->id == $visit->model->id)
                                        {{ $car->car_name }}
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <p class="text-gray-700 text-base">
                            Model: {{ $visit->model->model }}<br>
                            Cylinders: {{ $visit->model->cylinders }}<br>
                            Drive: {{ $visit->model->drive }}<br>
                            fueltype: {{ $visit->model->fueltype }}<br>
                            fueltype: {{ $visit->model->fueltype1 }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            function fetch_customer_cars(query = '') {
                $.ajax({
                    url: "{{ route('car.getCustomerCar') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        option = '<option value="';
                        optionTag = '">';
                        optionCloseTag = '</option>';
                        cars = '<option value="">-- Chooce Customer Car --</option>';
                        for (let index = 0; index < data.length; index++) {
                            cars += option + data[index]['car']['car_name'] + optionTag;
                            cars += data[index]['car']['car_name'] + optionCloseTag;
                        }
                        $('#cars').html(cars);
                    }
                });
            }

            function fetch_car_models(query = '') {
                $.ajax({
                    url: "{{ route('car.getCustomerCar') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        option = '<option value="';
                        optionTag = '">';
                        optionCloseTag = '</option>';
                        models = '<option value="">-- Chooce Car Model --</option>';
                        for (let index = 0; index < data.length; index++) {
                            if (data[index]['car']['car_name'] != $('#cars').val()) {
                                continue;
                            }
                            models += option + data[index]['model'] + optionTag;
                            models += data[index]['model'] + optionCloseTag;
                        }
                        $('#models').html(models);
                    }
                });
            }

            function fetch_car_data(model = '') {
                $.ajax({
                    url: "{{ route('car.getCarSpecs') }}",
                    method: 'GET',
                    data: {
                        model: model
                    },
                    success: function(data) {
                        $('#car_info').html(data);
                    },

                });
            }

            fetch_customer_cars($('#customer_fname').val());
            fetch_car_models($('#cars').val());


            $('#customer_fname').on('keyup', function() {
                var query = $(this).val();
                fetch_customer_cars(query);
            });

            $('#cars').on('change', function() {
                var query = $('#customer_fname').val();
                fetch_car_models(query);
            });

            $('#models').on('change', function() {
                $('#specs').removeClass('hidden');
                var model = $(this).val();
                fetch_car_data(model);
            });
        });
    </script>

</section>
