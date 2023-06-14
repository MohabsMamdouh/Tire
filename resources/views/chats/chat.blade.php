@section('pageTitle', $title)

<x-app-layout>

    <script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key='{{ config('app.BingMapsKey') }}"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <script>
        $(document).ready(function () {
            window.getMessages = function (customer) {
                $('#messagesShow').load(
                    "{{ route('chats.get.msg',['user' => Auth::user(), 'customer' => ':customer']) }}".replace(':customer', customer),
                    function (response, status, request) {
                        $('#messagesShow').html(response);
                        $('#messagesShow').scrollTop($('#messagesShow')[0].scrollHeight);
                });
                $('.controller').removeClass('hidden');
                customerInfo(customer);
            };

            window.customerInfo = function (customer) {
                $('#CustomerInfo').load(
                    "{{ route('customer.getCustomerInfo',['customer' => ':customer']) }}".replace(':customer', customer),
                    function (response, status, request) {
                        $('#CustomerInfo').html(response);
                });
            }

            window.send = function (cid) {
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

            window.fetch_customers = function (query = '') {
                $.ajax({
                    url: "{{ route('customer.searchChat') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#userList').html(data);
                    },
                    error: function (request, error) {
                        alert(" Can't do because: " + error);
                    }
                });
            }
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 w-full shadow sm:rounded-lg">
                @include('chats.partials.chatbox')
            </div>
        </div>
    </div>
</x-app-layout>
