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
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
        @endif
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

        {{-- zipCode --}}
        <div>
            <x-text-input id="zipCode" name="zipCode" type="text" class="mt-1 block w-full" required autofocus
                autocomplete="zipCode" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>


    </form>

</section>


<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(a) {
            if (a.coords) {
                $('#longitude').val(a.coords.longitude);
                $('#latitude').val(a.coords.latitude);
            }
        });
    } else {
        alert('navigator.geolocation not supported.');
    }
</script>
