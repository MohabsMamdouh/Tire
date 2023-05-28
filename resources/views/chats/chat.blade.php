@section('pageTitle', $title)

<x-app-layout>

    <script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key='{{ config('app.BingMapsKey') }}"></script>
    <script>
        $(document).ready(function () {
            $('#userList-item').on('click', function() {
                var cidValue = $(this).find('#cid').val();
                getMessages(cidValue);
                customerInfo(cidValue);
                $('.controller').removeClass('hidden');
            });

            $('#MessageSend').click(function (e) {
                e.preventDefault();

                var cid = $('#customer_id').val();
                send(cid);
            });

            function send(cid) {
                $.ajax({
                    type: "get",
                    url: "{{ route('chats.store.msg',['user' => Auth::user()->id, 'customer' => ':cid']) }}".replace(':cid', cid),
                    data: {
                        msg: $('#msg').val(),
                        sender: 'mechanic',
                    },
                    success: function (response) {
                        getMessages(cid);
                        $('#msg').val('');
                    },
                    error: function (request, error) {
                        console.log(arguments);
                        $('#msg').val('');
                        alert(" Can't do because: " + error);
                    }
                });
            }

            window.getMessages = function(customer) {
                $('#messagesShow').load(
                    "{{ route('chats.get.msg',['user' => Auth::user(), 'customer' => ':customer']) }}".replace(':customer', customer),
                    function (response, status, request) {
                        $('#messagesShow').html(response);
                        $('#message-overflow').scrollTop($('#message-overflow')[0].scrollHeight);
                });
            };

            function customerInfo(customer) {
                $('#CustomerInfo').load(
                    "{{ route('customer.getCustomerInfo',['customer' => ':customer']) }}".replace(':customer', customer),
                    function (response, status, request) {
                        $('#CustomerInfo').html(response);
                });
            }

            window.loadMapScenario = function (latitude, longitude) {
                var map = new Microsoft.Maps.Map('#map', {
                    center: new Microsoft.Maps.Location(latitude, longitude),
                    zoom: 12
                });
                var pushpin = new Microsoft.Maps.Pushpin(map.getCenter(), null);
                map.entities.push(pushpin);
            }
        });
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('chats.partials.chatbox')
            </div>
        </div>
    </div>
</x-app-layout>
