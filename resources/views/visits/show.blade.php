@section('pageTitle', $title)

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Visits') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                <div class="block mb-10">
                    <a href="{{ route('visit.create') }}"
                        class="bg-transparent hover:bg-blue-500 dark:bg-blue-500 dark:text-white text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        {{ __('Create Visit') }}
                    </a>
                </div>
                <div class="block m-auto px-4 py-2">
                    <input placeholder="Search for a visit ..." name="search" id="search" type="search"
                        class="block w-full bg-gray-200 focus:outline-none focus:bg-white focus:shadow text-gray-700 font-bold rounded-lg px-4 py-3" />
                    @include('visits.partials.tables')

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ route('visit.liveSearch') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('tbody').html(data);
                    }
                });
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>
</x-app-layout>
