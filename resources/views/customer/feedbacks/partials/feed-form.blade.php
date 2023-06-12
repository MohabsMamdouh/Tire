<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $title }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Feedback About your Visit.') }}
        </p>
    </header>

    <form method="post" class="mt-6 space-y-6" action="{{ Route::currentRouteName() == 'customer.feeds.create' ? route('customer.feeds.store', ['visit' => $visit]) : route('customer.feeds.update', ['feedback' => $feedback]) }}">
        @csrf
        <div>
            <x-input-label for="message" :value="__('Message')" />
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Feedback"
                class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                {{ Route::currentRouteName() == 'customer.feeds.edit' ? $feedback->message : "" }}
            </textarea>
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

</section>
