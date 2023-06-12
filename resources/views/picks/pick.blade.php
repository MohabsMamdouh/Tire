@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                <div class="block m-auto px-4 py-2">
                    <div class="card">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-2">{{ $customer->customer_fname }}</h2>
                            <div class="text-gray-600"><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ $customer->location->latitude }},{{ $customer->location->longitude }}">{{ $customer->location->address }} <i class="fa-solid fa-map"></i></a></div>
                            <a href="{{ route('picks.done', ['pickRequest' => $pickRequest->id]) }}" class="bg-blue-500 p-3 rounded text-white" type="submit">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
