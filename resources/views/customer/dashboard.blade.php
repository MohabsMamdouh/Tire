@extends('customer.layouts.app')

@section('heaader')
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap -mx-3">
                    @php
                        $arr = [['Cars', $countCars, 'fa-solid fa-car', 'from-blue-500 to-violet-500'], ['Mechanics', $countMechanic, 'fa-solid fa-clipboard-user', 'from-red-600 to-orange-600'], ['Visits', $countVisits, 'fa-sharp fa-solid fa-eye', 'from-emerald-500 to-teal-400'], ['Feedbacks', $countFeeds, 'fa-solid fa-face-smile', 'from-orange-500 to-yellow-500']];
                        
                    @endphp
                    <!-- cards -->
                    @foreach ($arr as $card)
                        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white dark:bg-gray-700 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex flex-row -mx-3">
                                        <div class="flex-none w-2/3 max-w-full px-3">
                                            <div>
                                                <p
                                                    class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">
                                                    {{ $card[0] }}
                                                </p>
                                                <h5 class="mb-2 font-bold dark:text-white">{{ $card[1] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="px-3 text-right basis-1/3">
                                            <div
                                                class="inline-block w-12 h-12 text-center rounded-full bg-gradient-to-tl {{ $card[3] }}">
                                                <i class="{{ $card[2] }} text-xlg relative top-3.5 text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- cards row 2 -->
                <div class="flex flex-wrap mt-6 -mx-3">
                    <div class="w-full max-w-full px-3 mt-0 lg:w-7/12 lg:flex-none">
                        <div
                            class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border dark:bg-gray-700">
                            <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0">
                                <h6 class="capitalize dark:text-white">{{ __('Visits overview') }}</h6>
                                <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                                    <i class="fa fa-arrow-up text-emerald-500"></i>
                                    <span class="font-semibold">{{ __('Latest Visits') }}</span>
                                </p>
                            </div>
                            <div class="flex-auto p-4">
                                <div>
                                    <table class="table-fixed dark:text-gray-200">
                                        <thead class="dark:bg-slate-500">
                                            <tr>
                                                <th class="px-2 py-2">{{ __('Car') }}</th>
                                                <th class="px-2 py-2">{{ __('Model') }}</th>
                                                <th class="px-2 py-2">{{ __('Reason') }}</th>
                                                <th class="px-2 py-2">{{ __('Mechanic') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($Visits as $visit)
                                                <tr>
                                                    <td class="border px-2 py-2">
                                                        {{ $visit->car_name }}
                                                    </td>
                                                    <td class="border px-2 py-2">{{ $visit->model }}</td>
                                                    <td class="border px-2 py-2">{{ $visit->reason }}</td>
                                                    <td class="border px-2 py-2">{{ $visit->mechanic }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full max-w-full h-100 px-3 lg:w-5/12 lg:flex-none rounded-2xl border-0 border-solid bg-white bg-clip-border dark:bg-gray-700">
                        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0">
                            <h6 class="capitalize dark:text-white">{{ __('Feedbacks') }}</h6>
                            <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                                <i class="fa fa-arrow-up text-emerald-500"></i>
                                <span class="font-semibold">{{ __('Latest Feedbacks') }}</span>
                            </p>
                        </div>
                        <div class="relative w-full h-full overflow-x-auto rounded-2xl">
                            @foreach ($feeds as $feed)
                                <a href="#"
                                    class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $feed->fname }}</h5>
                                    <p class="font-normal text-gray-700 dark:text-gray-400">
                                        <p class="text-gray-600 dark:text-gray-200">{{ $feed->message }}</p>
                                        <p class="text-gray-600 dark:text-gray-200">
                                            <b>
                                                {{ $feed->car_name }}
                                            </b> - {{ $feed->model }}
                                        </p>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>

<body>
    <div>You are in! {{ Auth::guard('customer')->user()->customer_fname }} are </div>
    <br>
    <form method="POST" action="{{ route('customer.logout') }}">
        @csrf

        <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="route('logout')" onclick="event.preventDefault();
                    this.closest('form').submit();">
            {{ __('Log Out') }}
        </a>
    </form>
</body>

</html> --}}
