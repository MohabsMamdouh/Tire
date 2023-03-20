<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') - {{ config('app.name', 'Tire') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="flex-col w-full md:flex md:flex-row md:min-h-screen">

            @include('layouts.sidebar')

            <div class="switcher" style="position: fixed;bottom: 0px; left: 20px">
                <div class="flex items-end mb-4">
                    <img src="{{ asset('storage/icon-moon.svg') }}" width="30px" class="moon cursor-pointer"
                        alt="">
                    <img src="{{ asset('storage/icon-sun.svg') }}" width="30px" class="sun cursor-pointer"
                        alt="">
                </div>
            </div>

            <div class="w-full">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    {{-- <script src="{{ URL::asset('js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('js/argon-dashboard-tailwind.js?v=1.0.1') }}"></script> --}}

</body>

</html>
