@extends('customer.layouts.app')

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
                <div class="block m-auto px-4 py-2">
                    <div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
                        <div class="dark:text-gray-200 shadow">
                            <div class="flex flex-col justify-center">
                                <div class="card">
                                    <div class="bg-white dark:bg-transparent rounded-lg shadow p-6">
                                        <h2 class="text-xl font-semibold mb-2">{{ $user->fname }}</h2>
                                        <div class="flex flex-start dark:text-gray-200">
                                            <button id="pickMe" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">{{ __('Pick Me') }}</button>
                                            <b><p id="status" class="text-sm uppercase text-gray-600 p-2 dark:text-gray-400"></p></b>
                                            {{-- <div id="status">
                                            </div> --}}
                                        </div>
                                        <div class="text-gray-600">
                                            <div><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ $user->addresses[0]->address_latitude }},{{ $user->addresses[0]->address_longitude }}">{{ $user->addresses[0]->address_address }} <i class="fa-solid fa-map"></i></a></div>
                                        </div>
                                        <div class="font-semibold py-4 dark:text-gray-200">{{ $user->phone }}</div>
                                    </div>
                                </div>

                                <div class="feedbacks m-4">
                                    <h4>{{ __('Feedbacks') }}</h4>
                                    @foreach ($feeds as $feed)
                                        <div class="bg-gray-500 dark:bg-white border border-gray-300 rounded-lg p-4 m-2 shadow-md">
                                            <p class="text-gray-200 dark:text-gray-800 font-medium">{{ $feed->message }}</p>
                                            <p class="text-gray-200 dark:text-gray-600 mt-2">{{ __('By ') . $feed->customer }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#pickMe").on("click", function() {
                $("#status").load("{{ route('customer.pick.store', ['user' => $user->id, 'customer' => Auth::guard('customer')->user()->id]) }}","data", function (response, status, request) {
                    // $('#pickMe').css('');
                    $('#pickMe').prop('disabled', true);
                    // console.log(response);
                });
            });

            function checkStatus() {
                $('#status').load(
                    "{{ route('customer.pick.checkStatus',['user' => $user->id, 'customer' => Auth::guard('customer')->user()->id]) }}",
                    function (response, status, request) {
                });
            }

            setInterval(function(){
                checkStatus();
            }, 5000);
        });
    </script>
@endsection
