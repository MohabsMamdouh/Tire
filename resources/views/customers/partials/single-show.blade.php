{{-- <div class="p-16"> --}}
<div class="p-8 bg-white dark:bg-slate-500 dark:text-gray-200 shadow">
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="grid grid-cols-3 text-center order-last md:order-first mt-20 md:mt-0">
            <div>
                <p class="font-bold text-gray-700 dark:text-gray-100 text-xl">{{ count($customer->visits) }}</p>
                <p class="text-gray-400 dark:text-gray-300">{{ __('Visits') }}</p>
            </div>
            <div>
                <p class="font-bold text-gray-700 dark:text-gray-100 text-xl">{{ count($customer->feedbacks) }}</p>
                <p class="text-gray-400 dark:text-gray-300">{{ __('Feedback') }}</p>
            </div>
        </div>
        <div class="relative">
            <div
                class="w-48 h-48 bg-indigo-100 mx-auto rounded-full shadow-2xl absolute inset-x-0 top-0 -mt-24 flex items-center justify-center text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <div class="space-x-8 flex justify-between mt-32 md:mt-0 md:justify-center">
            <a href="{{ route('car.addToCustomer', ['cid' => $customer->id]) }}"
                class="text-white m-auto py-4 px-4 uppercase rounded bg-blue-400 hover:bg-blue-500 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5">
                {{ __('Cars') }}
            </a>

            <a href="{{ route('customer.showMyVisits', ['id' => $customer->id]) }}"
                class="text-white m-auto py-4 px-4 uppercase rounded bg-blue-400 hover:bg-blue-500 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5">
                {{ __('Visits') }}
            </a>
            @can('update customer')
                <a href="{{ route('customer.edit', ['id' => $customer->id]) }}"
                    class="text-white m-auto w-40 py-4 px-4 p-0 uppercase rounded bg-gray-700 hover:bg-gray-800 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5">
                    {{ __('Update') }}
                </a>
            @endcan
        </div>
    </div>
    <div class="mt-20 text-center border-b pb-12">
        <h1 class="text-4xl font-medium text-gray-700 dark:text-gray-100">
            {{ $customer->customer_fname }},
            <span class="font-light text-gray-500 dark:text-gray-300">
                {{ $customer->customerusername }}
            </span>
        </h1>
        <p class="font-light text-gray-600 dark:text-gray-300 mt-3">{{ $customer->customer_address }}</p>
        {{-- <p class="mt-8 text-gray-500 dark:text-gray-300">
            -
        </p> --}}
    </div>
    <div class="mt-12 flex flex-col justify-center">
        <table class="table-fixed">
            <thead>
                <tr>
                    <th class="w-1/2 px-4 py-2">{{ __('Car') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Model') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Cylinders') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Drive') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('fueltype') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('fueltype1') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carData as $car)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $car->car->car_name }}
                        </td>
                        <td class="border px-4 py-2">{{ $car->model }}</td>
                        <td class="border px-4 py-2">{{ $car->cylinders }}</td>
                        <td class="border px-4 py-2">{{ $car->drive }}</td>
                        <td class="border px-4 py-2">{{ $car->fueltype }}</td>
                        <td class="border px-4 py-2">{{ $car->fueltype1 }}</td>
                        <td class="border px-4 py-2 bg-red-500 text-white">
                            <a href="{{ route('car.destroy', ['cid' => $customer->id, 'model_id' => $car->id]) }}">
                                <svg class="svg-icon fill-current text-white stroke-1 text-white-600 text-2xl m-auto "
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M17.114,3.923h-4.589V2.427c0-0.252-0.207-0.459-0.46-0.459H7.935c-0.252,0-0.459,0.207-0.459,0.459v1.496h-4.59c-0.252,0-0.459,0.205-0.459,0.459c0,0.252,0.207,0.459,0.459,0.459h1.51v12.732c0,0.252,0.207,0.459,0.459,0.459h10.29c0.254,0,0.459-0.207,0.459-0.459V4.841h1.511c0.252,0,0.459-0.207,0.459-0.459C17.573,4.127,17.366,3.923,17.114,3.923M8.394,2.886h3.214v0.918H8.394V2.886z M14.686,17.114H5.314V4.841h9.372V17.114z M12.525,7.306v7.344c0,0.252-0.207,0.459-0.46,0.459s-0.458-0.207-0.458-0.459V7.306c0-0.254,0.205-0.459,0.458-0.459S12.525,7.051,12.525,7.306M8.394,7.306v7.344c0,0.252-0.207,0.459-0.459,0.459s-0.459-0.207-0.459-0.459V7.306c0-0.254,0.207-0.459,0.459-0.459S8.394,7.051,8.394,7.306">
                                    </path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- </div> --}}
