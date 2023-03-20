{{-- <div class="p-16"> --}}
<div class="p-8 bg-white dark:bg-slate-500 dark:text-gray-200 shadow">
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="grid grid-cols-3 text-center order-last md:order-first mt-20 md:mt-0">
            <div>
                <p class="font-bold text-gray-700 dark:text-gray-100 text-xl">{{ count($user->visits) }}</p>
                <p class="text-gray-400 dark:text-gray-300">{{ __('Visits') }}</p>
            </div>
            <div>
                <p class="font-bold text-gray-700 dark:text-gray-100 text-xl">10</p>
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
            @can('assign permission')
                <a href="{{ route('access.userAssign', ['id' => $user->id]) }}"
                    class="text-white py-4 px-4 uppercase rounded bg-blue-400 hover:bg-blue-500 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5">
                    {{ __('permissions') }}
                </a>
            @endcan
            @can('update user')
                <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                    class="text-white w-40 py-4 px-4 p-0 uppercase rounded bg-gray-700 hover:bg-gray-800 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5">
                    <svg class="svg-icon fill-gray-200 stroke-slate-200 m-auto inline" viewBox="0 0 20 20">
                        <path fill="none"
                            d="M19.404,6.65l-5.998-5.996c-0.292-0.292-0.765-0.292-1.056,0l-2.22,2.22l-8.311,8.313l-0.003,0.001v0.003l-0.161,0.161c-0.114,0.112-0.187,0.258-0.21,0.417l-1.059,7.051c-0.035,0.233,0.044,0.47,0.21,0.639c0.143,0.14,0.333,0.219,0.528,0.219c0.038,0,0.073-0.003,0.111-0.009l7.054-1.055c0.158-0.025,0.306-0.098,0.417-0.211l8.478-8.476l2.22-2.22C19.695,7.414,19.695,6.941,19.404,6.65z M8.341,16.656l-0.989-0.99l7.258-7.258l0.989,0.99L8.341,16.656z M2.332,15.919l0.411-2.748l4.143,4.143l-2.748,0.41L2.332,15.919z M13.554,7.351L6.296,14.61l-0.849-0.848l7.259-7.258l0.423,0.424L13.554,7.351zM10.658,4.457l0.992,0.99l-7.259,7.258L3.4,11.715L10.658,4.457z M16.656,8.342l-1.517-1.517V6.823h-0.003l-0.951-0.951l-2.471-2.471l1.164-1.164l4.942,4.94L16.656,8.342z">
                        </path>
                    </svg>

                    {{ __('Update') }}
                </a>
            @endcan
        </div>
    </div>
    <div class="mt-20 text-center border-b pb-12">
        <h1 class="text-4xl font-medium text-gray-700 dark:text-gray-100">
            {{ $user->fname }},
            <span class="font-light text-gray-500 dark:text-gray-300">
                {{ $user->username }}
            </span>
        </h1>
        <p class="font-light text-gray-600 dark:text-gray-300 mt-3">{{ $user->email }}</p>
        <p class="mt-8 text-gray-500 dark:text-gray-300">
            @isset($user->roles[0])
                {{ str_replace('_', ' ', Str::upper($user->roles[0]->name)) }}
            @endisset
            -
        </p>
        <p class="mt-2 text-gray-500 dark:text-gray-300">{{ $user->title }}</p>
    </div>
    <div class="mt-12 flex flex-col justify-center">
        <table class="table-fixed">
            <thead>
                <tr>
                    <th class="w-1/2 px-4 py-2">{{ __('Car') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Reason') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Date') }}</th>
                    <th class="w-1/4 px-4 py-2">{{ __('Customer') }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($user->visits) }} --}}
                @foreach ($user->visits as $visit)
                    <tr>
                        <td class="border px-4 py-2">
                            @foreach ($customers as $customer)
                                @foreach ($customer->models as $model)
                                    @if ($visit->car_model_id == $model->id)
                                        @foreach ($cars as $car)
                                            @foreach ($car->models as $carModel)
                                                @if ($carModel->id == $model->id)
                                                    {{ $car->car_name . ' - ' . $model->model }}
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">{{ $visit->reason }}</td>
                        <td class="border px-4 py-2">{{ $visit->created_at }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($customers as $customer)
                                @foreach ($customer->models as $model)
                                    @if ($visit->car_model_id == $model->id)
                                        {{ $customer->customer_fname }}
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
{{-- </div> --}}
