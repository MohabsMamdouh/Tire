<section>
    {{-- <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ $BingMapsKey }}'
        async defer></script> --}}
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport"
        content="user-scalable=no, initial-scale=1,
                 maximum-scale=1,  minimum-scale=1,
                 width=device-width,  height=device-height,
                 target-densitydpi=device-dpi" />

    <script type="text/javascript" src="https://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ Route::currentRouteName() == 'customer.edit' ? __('Update Customer') : __('Create New Customer') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update or Add Customer Information.') }}
        </p>
    </header>


    <div onload="getLocation();">
        <form method="post" class="mt-6 space-y-6 myForm" action="{{ route('address.location.store') }}">
            @csrf

            {{-- <div>
                <iframe width="500" height="400" frameborder="0"
                    src="https://www.bing.com/maps/embed?h=400&w=500&cp=30.045047094688513~31.290967969911776&lvl=13.413141983634729&typ=d&sty=h&src=SHELL&FORM=MBEDV8"
                    scrolling="no">
                </iframe>
                <div style="white-space: nowrap; text-align: center; width: 500px; padding: 6px 0;">
                    <a id="largeMapLink" target="_blank"
                        href="https://www.bing.com/maps?cp=30.045047094688513~31.290967969911776&amp;sty=h&amp;lvl=13.413141983634729&amp;FORM=MBEDLD">View
                        Larger Map</a> &nbsp; | &nbsp;
                    <a id="dirMapLink" target="_blank"
                        href="https://www.bing.com/maps/directions?cp=30.045047094688513~31.290967969911776&amp;sty=h&amp;lvl=13.413141983634729&amp;rtp=~pos.30.045047094688513_31.290967969911776____&amp;FORM=MBEDLD">Get
                        Directions</a>
                </div>
            </div> --}}


            {{-- Country_name --}}
            {{-- <div>
                <x-input-label for="Country_name" :value="__('Country Name')" />
                <select name="Country_name" id="Country_name"
                    class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                    <option value="">-- {{ __('Chooce The Country') }} --</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country[0] }}">{{ $country[1] }}</option>
                    @endforeach
                </select>
                @error('Country_name')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            {{-- State Name --}}
            {{-- <div>
                <x-input-label for="State_name" :value="__('State Name')" />
                <x-text-input id="State_name" name="State_name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="State_name" />

                @error('State_name')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            {{-- Zip Code --}}
            {{-- <div>
                <x-input-label for="zip_code" :value="__('Zip Code')" />
                <x-text-input id="zip_code" name="zip_code" type="tel" class="mt-1 block w-full" required autofocus
                    autocomplete="zip_code" />

                @error('zip_code')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            {{-- City Name --}}
            {{-- <div>
                <x-input-label for="City_name" :value="__('City Name')" />
                <x-text-input id="City_name" name="City_name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="City_name" />

                @error('City_name')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            {{-- Street Name --}}
            {{-- <div>
                <x-input-label for="street_name" :value="__('Street Name')" />
                <x-text-input id="street_name" name="street_name" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="street_name" />

                @error('street_name')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            {{-- <div>
                <x-input-label for="latitude" :value="__('latitude')" />
                <x-text-input id="latitude" name="latitude" type="hidden" class="mt-1 block w-full" required autofocus
                    autocomplete="latitude" />

                @error('latitude')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <x-input-label for="longitude" :value="__('longitude')" />
                <x-text-input id="longitude" name="longitude" type="hidden" class="mt-1 block w-full" required
                    autofocus autocomplete="longitude" />

                @error('longitude')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}


            <div>
                <x-input-label for="longitude" :value="__('longitude')" />
                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="longitude" />

                @error('longitude')
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

    {{-- <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            }
        }

        function showPosition(position) {
            document.querySelector('.myForm input[name="latitude"]').value = position.coords.latitude;
            document.querySelector('.myForm input[name="longitude"]').value = position.coords.longitude;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISION_DENIED:
                    alert('You Must Allow the request for Geolocation to fill The Form');
                    location.reload();
                    break;
            }
        }
    </script> --}}

</section>
