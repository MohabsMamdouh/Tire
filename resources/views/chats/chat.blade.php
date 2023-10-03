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

            var head1 = '<div class="flex items-center message justify-start mb-4">';
            var head2 = '<div class="flex items-center message justify-end mb-4">';
            var icon = '<div class="rounded-full bg-gray-300 h-8 w-8 flex items-center justify-center mr-4">'
                        +'<span class="font-bold text-sm"><i class="fas fa-user"></i></span></div>';
            var msgOpen1 = '<div class="bg-gray-200 rounded-lg p-3 mb-2 max-w-xs"><p>';
            var msgClose = '</p></div>';

            var msgOpen2 = '<div class="bg-blue-500 rounded-lg p-3 ml-4 max-w-xs text-white"><p>';


            var usr = '<div class="flex flex-col ml-2"><span class="font-bold text-sm">';
            var usrTime = '</span><span class="text-xs text-gray-500">';
            var usrend = '</span></div>';

            var headClose = '</div>';

            $("#msgs").css("height", (window.innerHeight - 200));

            function wordwrap(str, width, brk, cut) {
                brk = brk || '\n';
                width = width || 75;
                cut = cut || false;

                if (!str) {
                    return str;
                }

                var regex = '.{1,' + width + '}(\\s|$)' + (cut ? '|.{' + width + '}|.+$' : '|\\S+?(\\s|$)');
                return str.match(new RegExp(regex, 'g')).join(brk);
            }

            window.myMessage = function (msg, time, fname="YOU") {
                var html = "";

                if(fname == "YOU") {
                    html = head2 + usr + fname;
                    html += usrTime + time + usrend;
                    html += msgOpen2 + msg + msgClose + headClose;
                } else {
                    html = head1 + icon + msgOpen1 + msg + msgClose + usr;

                    html += fname + usrTime + time + usrend + headClose;
                }
                $("#messagesShow").append(html);
            }



            window.getMessages = function (customer) {

                $("#messagesShow").html(" ");

                $.ajax({
                    type: "get",
                    url: "{{ route('chats.get.msg',['user' => Auth::user(), 'customer' => ':customer']) }}".replace(':customer', customer),
                    success: function (response) {
                        response.forEach(msg => {
                            if(msg['sender'] == "customer") {
                                myMessage(wordwrap(msg.message, 20, "<br>", true), msg.created_at.replace(/-/g, ' '), msg.customer_fname);
                            } else {
                                myMessage(wordwrap(msg.message, 20, "<br>", true), msg.created_at.replace(/-/g, ' '), "YOU");
                            }
                        });
                        $('#msgs').scrollTop($('#msgs')[0].scrollHeight);
                    }
                });
            };

            window.customerInfo = function (customer) {
                $.ajax({
                    type: "get",
                    url: "{{ route('customer.getCustomerInfo',['customer' => ':customer']) }}".replace(':customer', customer),
                    success: function (response) {
                        $("#cInfo p").html(response['customer_fname']);
                        $("#cInfo small.address").html(response['customer_address']);
                        $("#cInfo small.phone").html(response['customer_phone']);
                    }
                });
            }

            window.send = function (cid) {
                $.ajax({
                    type: "get",
                    url: "{{ route('chats.store.msg',['user' => Auth::user()->id, 'customer' => ':cid']) }}".replace(':cid', cid),
                    data: {
                        msg: $('#message').val(),
                        sender: 'mechanic',
                    },
                    success: function (response) {
                        var now = new Date();
                        myMessage($("form #message").val(), now);
                        $('#message').val('');
                        $(document).scrollTop($(document).height());
                    },
                    error: function (request, error) {
                        console.log(arguments);
                        $('#message').val('');
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
