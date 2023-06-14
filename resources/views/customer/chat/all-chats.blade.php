@extends('customer.layouts.app')

<style>
    .scrollbar-w-2::-webkit-scrollbar {
      width: 0.25rem;
      height: 0.25rem;
    }

    .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
      --bg-opacity: 1;
      background-color: #f7fafc;
      background-color: rgba(247, 250, 252, var(--bg-opacity));
    }

    .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
      --bg-opacity: 1;
      background-color: #edf2f7;
      background-color: rgba(237, 242, 247, var(--bg-opacity));
    }

    .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
      border-radius: 0.25rem;
    }
</style>

{{-- <script>
    $(document).ready(function () {
        window.getMessages = function (user) {
            $('#messagesShow').load(
                "{{ route('customer.chat.get.msg',['user' => ':user', 'customer' => Auth::guard('customer')->user()->id]) }}".replace(':user', user),
                function (response, status, request) {
                    $('#messagesShow').html(response);
                    $('#messagesShow').scrollTop($('#messagesShow')[0].scrollHeight);
            });
            $('.controller').removeClass('hidden');
            userInfo(user);
        }

        window.userInfo = function (user) {
            $('#UserInfo').load(
                "{{ route('customer.user.getUserInfo',['user' => ':user']) }}".replace(':user', user),
                function (response, status, request) {
                    $('#UserInfo').html(response);
            });
        }


        window.send = function (cid) {
            $.ajax({
                type: "get",
                url: "{{ route('customer.chat.store.msg',['user' => ':cid', 'customer' => Auth::guard('customer')->user()]) }}".replace(':cid', cid),
                data: {
                    msg: $('#msg').val(),
                    sender: 'customer',
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
                    url: "{{ route('customer.user.searchChat') }}",
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
</script> --}}


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
                {{-- <div class="max-w-xl"> --}}
                    @include('customer.chat.partials.chatsbox')
                {{-- </div> --}}
            </div>
        </div>
    </div>
@endsection
