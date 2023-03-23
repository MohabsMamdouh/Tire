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
            {{ __('Adding your Current Location') }}
        </h2>
        @if (session('status') === 'Added Successfully')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
        @endif
        {{-- <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update or Add Customer Information.') }}
        </p> --}}
    </header>

    <form method="post" class="mt-6 space-y-6" action="{{ route('address.location.store') }}">
        @csrf

        {{-- latitude --}}
        <div>
            <x-text-input id="latitude" name="latitude" type="hidden" class="mt-1 block w-full" required autofocus
                autocomplete="latitude" />
        </div>


        {{-- longitude --}}
        <div>
            <x-text-input id="longitude" name="longitude" type="hidden" class="mt-1 block w-full" required autofocus
                autocomplete="longitude" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>


    </form>

</section>


<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(a) {
            // for (var t in a) {
            //     // $('#general').append('<em>' + t + '</em> : ' + a[t] + '<br/>');
            //     // alert(t + ': ' + a[t]);
            //     console.console.log();
            // }

            // if (a.address) {
            //     for (var t in a.address) {
            //         // $('#address').append('<em>' + t + '</em> : ' + a.address[t] + '<br/>');
            //         alert(t + ': ' + a.address[t]);

            //     }
            // }

            if (a.coords) {
                for (var t in a.coords) {
                    // $('#coords').append('<em>' + t + '</em> : ' + a.coords[t] + '<br/>');
                    // alert(t + ': ' + a.coords[t]);
                    console.log(t + ': ' + a.coords[t]);
                }

                console.log(a.coords);
                $('#longitude').val(a.coords.longitude);
                $('#latitude').val(a.coords.latitude);

                var point = new google.maps.LatLng(a.coords.latitude, a.coords.longitude);
                new google.maps.Geocoder().geocode({
                        'latLng': point
                    },
                    function(res, status) {
                        var zip = res[0].formatted_address.match(/,\s\w{2}\s(\d{5})/);
                        $("#zipCode").val(zip);
                    }
                );

            }
        });
    } else {
        alert('navigator.geolocation not supported.');
    }
</script>
