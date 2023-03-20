<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($feeds as $feed)
            <div
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $feed->fname }}
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                <p class="text-gray-600 dark:text-gray-200">{{ $feed->message }}</p>
                <p class="text-gray-600 dark:text-gray-200">
                    <b>
                        {{ $feed->car_name }}
                    </b> - {{ $feed->model }}
                </p>
            </div>
        @endforeach
    </div>
</div>
</div>
