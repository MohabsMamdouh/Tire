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

    <div class="show">
        <div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3" id="showMechanics">

            </div>
        </div>

    </div>

</section>


<script>
    $(document).ready(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(a) {
                if (a.coords) {
                    $.ajax({
                        url: "{{ route('address.mechanicsNearMe') }}",
                        method: 'get',
                        data: {
                            long: a.coords.longitude,
                            lat: a.coords.latitude,
                        },
                        success: function(data) {
                            $('#showMechanics').html(data);
                        }
                    });
                }
            });
        } else {
            alert('navigator.geolocation not supported.');
        }
    });
</script>
