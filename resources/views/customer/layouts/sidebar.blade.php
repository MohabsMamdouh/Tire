<div @click.away="open = false"
    class="flex flex-col flex-shrink-0 w-full text-gray-700 bg-white md:w-64 dark:text-gray-200 dark:bg-gray-800"
    x-data="{ open: false }">
    <div class="flex flex-row items-center justify-between flex-shrink-0 px-8 py-4">
        <a href="{{ route('customer.dashboard') }}"
            class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">
            <svg class="h-8 fill-current inline" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512.005 512.005">
                <rect fill="#2a2a31" x="16.539" y="425.626" width="479.767" height="50.502"
                    transform="matrix(1,0,0,1,0,0)" />
                <path class="plane-take-off"
                    d=" M 510.7 189.151 C 505.271 168.95 484.565 156.956 464.365 162.385 L 330.156 198.367 L 155.924 35.878 L 107.19 49.008 L 211.729 230.183 L 86.232 263.767 L 36.614 224.754 L 0 234.603 L 45.957 314.27 L 65.274 347.727 L 105.802 336.869 L 240.011 300.886 L 349.726 271.469 L 483.935 235.486 C 504.134 230.057 516.129 209.352 510.7 189.151 Z " />
            </svg>
            {{ config('app.name', 'Tire') }}
        </a>
        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                <path x-show="!open" fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
                <path x-show="open" fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <nav :class="{ 'block': open, 'hidden': !open }" class="flex-grow px-4 pb-4 md:block md:pb-0 md:overflow-y-auto">

        {{-- Profile & Logout Links --}}
        <div @click.away="open = false" class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left
                {{ Route::currentRouteName() == 'customer.profile.edit' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
                rounded-lg dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                <span>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::guard('customer')->user()->customer_fname }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::guard('customer')->user()->email }}</div>
                </span>
                <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': open, 'rotate-0': !open }"
                    class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                <div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-700">
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                        href="{{ route('customer.profile.edit') }}">
                        {{ __('Profile') }}
                    </a>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href="route('customer.logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- Dashboard Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.dashboard' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.dashboard') }}">
            {{ __('Dashboard') }}
        </a>

        {{-- Messages Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.chat.msgs' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.chat.msgs') }}">
            {{ __('Messages') }}
        </a>

        {{-- Cars Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.cars.show' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.cars.show') }}">
            {{ __('My Cars') }}
        </a>

        {{-- Visits Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.visits.MyVisits' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.visits.MyVisits') }}">
            {{ __('Give Feedbacks') }}
        </a>

        {{-- Feedbacks Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.feeds.MyFeeds' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.feeds.MyFeeds') }}">
            {{ __('My Feedbacks') }}
        </a>

        {{-- Mechanics Link --}}
        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900
            {{ Route::currentRouteName() == 'customer.location.showMechanicsNearMe' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}
            rounded-lg  dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('customer.location.showMechanicsNearMe') }}">
            {{ __('Mechanics near me') }}
        </a>


    </nav>
</div>
