@extends('customer.layouts.app')

@section('header')
    <script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key='{{ config('app.BingMapsKey') }}"></script>
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Chats') }}
            </h2>
        </div>
    </header>
@endsection


@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 w-full shadow sm:rounded-lg">
                <div class="container shadow-lg rounded-lg">
                    <!-- Chatting -->
                    <div class="flex flex-row justify-between">
                        <!-- chat list -->
                        <div class="flex flex-col w-1/3 border-r-2 dark:border-gray-400 h-screen">

                            <!-- search compt -->
                            <div class="border-b-2 dark:border-gray-400 py-4 px-2">
                                <input
                                name="search" id="search" type="search"
                                placeholder="Search Customers"
                                class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                                />
                            </div>
                            <!-- end search compt -->


                            <!-- user list -->
                            <div id="userList" class="overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                                @include('customer.chat.partials.userslist')
                            </div>

                            <!-- end user list -->
                        </div>
                        <!-- end chat list -->

                        <!-- message -->
                        <div class="flex flex-col h-screen w-5/6 mx-auto p-3">
                            <div class="chat hidden">
                                <div id="cInfo" class="top bg-gray-300 m-auto p-2">
                                    <div>
                                        <i class="fas fa-user"></i>
                                        <p></p>
                                        <small class="address"></small><br>
                                        <small class="phone"></small>
                                    </div>

                                </div>
                                <hr class="border-2 border-gray-500 dark:border-gray-200 rounded-lg">

                                <div id="msgs" class="messages w-full bg-gray-100 m-auto p-2" style="overflow: scroll">
                                    <div id="messagesShow"></div>
                                    {{-- @include('chats.partials.receive', ['message' => "Hey there, what's up?"]) --}}
                                </div>

                                <div class="bottom">
                                    <form>
                                        <div class="usr"></div>
                                        {{-- <input type="text" name="message" id="message" placeholder="Enter Your Message ....."> --}}
                                        <input class="w-full bg-gray-300 py-5 px-3" name="message" id="message" type="text" placeholder="type your message here..."  />
                                        <button type="submit"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end message -->


                    </div>
                    <!-- end message -->
                </div>

            </div>
        </div>
    </div>

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

            window.wordwrap = function (str, width, brk, cut) {
                brk = brk || '\n';
                width = width || 75;
                cut = cut || false;

                if (!str) {
                    return str;
                }

                var regex = '.{1,' + width + '}(\\s|$)' + (cut ? '|.{' + width + '}|.+$' : '|\\S+?(\\s|$)');
                return str.match(new RegExp(regex, 'g')).join(brk);
            }

            window.userInfo = function (user) {
                $.ajax({
                    type: "get",
                    url: "{{ route('customer.user.getUserInfo',['user' => ':user']) }}".replace(':user', user),
                    success: function (response) {
                        $("#cInfo p").html(response['fname']);
                        if (response['addresses'] != undefined) {
                            $("#cInfo small.address").html(response['addresses'][0]['address_address']);
                        }

                        if (response['phone']) {
                            $("#cInfo small.phone").html(response['phone']);
                        }
                    },
                    error: function (request, error) {
                        console.log(arguments);
                        alert(" Can't do because: " + error);
                    }
                });
            }

            window.getMessages = function (user) {
                $("#messagesShow").html(" ");

                $.ajax({
                    type: "get",
                    url: "{{ route('customer.chat.get.msg',['user' => ':user', 'customer' => Auth::guard('customer')->user()->id]) }}".replace(':user', user),
                    success: function (response) {
                        response.forEach(msg => {
                            if(msg['sender'] == "mechanic") {
                                myMessage(wordwrap(msg.message, 20, "<br>", true), msg.created_at.replace(/-/g, ' '), msg.fname);
                            } else {
                                myMessage(wordwrap(msg.message, 20, "<br>", true), msg.created_at.replace(/-/g, ' '), "YOU");
                            }
                        });
                        $('#msgs').scrollTop($('#msgs')[0].scrollHeight);
                    }
                });
            };

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

            window.send = function (cid) {
                $.ajax({
                    type: "get",
                    url: "{{ route('customer.chat.store.msg',['user' => ':cid', 'customer' => Auth::guard('customer')->user()]) }}".replace(':cid', cid),
                    data: {
                        msg: $('#message').val(),
                        sender: 'customer',
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

            $("form").submit(function (e) {
                e.preventDefault();
                send($("#cid").val());
            });

            $('.userList-item').on('click', function() {
                var cidValue = $(this).find('#cid').val();
                getMessages(cidValue);
                userInfo(cidValue);
                $('.chat').removeClass('hidden');
                $("form .usr").html('<input type="hidden" name="cid" id="cid" value="'+ cidValue +'">');
            });
        });



    </script>
@endsection
