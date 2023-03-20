<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($feeds as $feed)
            <div
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $feed->customer_fname }}
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                <p class="text-gray-600 dark:text-gray-200">{{ $feed->message }}</p>
                <p class="text-gray-600 dark:text-gray-200">
                    <b>
                        {{ $feed->car_name }}
                    </b> - {{ $feed->model }}
                </p>
                <p class="text-gray-600 dark:text-gray-200">{{ $feed->fname }}</p>
                @if (Route::currentRouteName() == 'feed.show_accept' && Auth::user()->can('accept feedbacks'))
                    <div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3">
                            <a href="{{ route('feed.destroy', ['feedback' => $feed->id]) }}"
                                class="bg-transparent hover:bg-red-500 dark:bg-red-500 dark:text-white text-red-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                {{ __('Delete Feedback') }}
                            </a>

                            <a href="{{ route('feed.accept', ['feedback' => $feed->id]) }}"
                                class="bg-transparent hover:bg-green-500 dark:bg-green-500 dark:text-white text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                                {{ __('Accept') }}
                            </a>
                        </div>
                    </div>
                @endif
                </p>
            </div>
        @endforeach
    </div>
</div>
</div>
