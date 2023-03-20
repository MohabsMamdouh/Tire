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
                                <table class="table-fixed">
                                    <thead class="dark:bg-slate-500">
                                        <tr>
                                            <th class="px-2 py-2">{{ __('Customer Name') }}</th>
                                            <th class="px-2 py-2">{{ __('Car') }}</th>
                                            <th class="px-2 py-2">{{ __('Model') }}</th>
                                            <th class="px-2 py-2">{{ __('Reason') }}</th>
                                            <th class="px-2 py-2">{{ __('Mechanic') }}</th>
                                            <th class="px-2 py-2">{{ __('Date') }}</th>
                                            <th class="px-2 py-2">{{ __('Feedback') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($visits as $visit)
                                            <tr>
                                                <td class="border px-2 py-2">{{ $visit->customer }}</td>
                                                <td class="border px-2 py-2">{{ $visit->car_name }}</td>
                                                <td class="border px-2 py-2">{{ $visit->model }}</td>
                                                <td class="border px-2 py-2">{{ $visit->reason }}</td>
                                                <td class="border px-2 py-2">{{ $visit->mechanic }}</td>
                                                <td class="border px-2 py-2">{{ $visit->created_at }}</td>
                                                <td class="border px-2 py-2">
                                                    <a href="{{ route('customer.feeds.create', ['visit' => $visit->id]) }}"
                                                        class="text-blue-400 underline">{{ _('Add Feedback') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
