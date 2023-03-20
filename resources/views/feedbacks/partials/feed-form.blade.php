<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create Feedback') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Create Feedback For Customer.') }}
        </p>
    </header>


    <form method="post" class="mt-6 space-y-6" action="{{ route('feed.store') }}">
        @csrf


        {{-- Customer Name --}}
        <div>
            <x-input-label for="customer_fname" :value="__('Customer Name')" />
            @if (isset($visit))
                <x-text-input id="customer_fname" list="customersList" name="customer_fname" type="text"
                    class="mt-1 block w-full" value="{{ $visit->customer->customer_fname }}" required autofocus
                    autocomplete="customer_fname" />
            @else
                <x-text-input id="customer_fname" list="customersList" name="customer_fname" type="text"
                    aria-placeholder="Customer Name ......" class="mt-1 block w-full" required autofocus
                    autocomplete="customer_fname" />
            @endif
            <datalist id="customersList">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->customer_fname }}">{{ $customer->customer_fname }}</option>
                @endforeach
            </datalist>

            @error('customer_fname')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Visits --}}
        <div>
            <x-input-label for="visits" :value="__('Visit')" />
            <select name="visits" id="visits" required
                class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                {{-- <option value="">-- {{ __('Chooce Customer Visit') }} --</option> --}}

            </select>
            @error('visits')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div>
            <x-input-label for="message" :value="__('Message')" />
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Feedback"
                class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"></textarea>
            @error('message')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>


    </form>


    <script>
        $(document).ready(function() {

            function fetch_customer_visits(query) {
                $.ajax({
                    url: "{{ route('visit.getCustomerVisits') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        option = '<option value="';
                        optionTag = '">';
                        optionCloseTag = '</option>';
                        visits = '<option value="">-- Chooce Customer Visit --</option>';
                        for (let index = 0; index < data.length; index++) {
                            visits += option + data[index]['id'] + optionTag;
                            visits += data[index]['created_at'] + optionCloseTag;
                        }
                        $('#visits').html(visits);
                    }
                });
            }

            $('#customer_fname').on('keyup', function() {
                var query = $(this).val();
                fetch_customer_visits(query);
            });
        });
    </script>


</section>
