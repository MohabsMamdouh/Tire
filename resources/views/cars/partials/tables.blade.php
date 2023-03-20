<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="dark:text-gray-200 shadow">
        <div class="flex flex-col justify-center">
            <table class="table-fixed">
                <thead class="dark:bg-slate-500">
                    <tr>
                        <th class="px-2 py-2">{{ __('Car') }}</th>
                        <th class="px-2 py-2">{{ __('Model') }}</th>
                        <th class="px-2 py-2">{{ __('Cylinders') }}</th>
                        <th class="px-2 py-2">{{ __('Drive') }}</th>
                        <th class="px-2 py-2">{{ __('eng_dscr') }}</th>
                        <th class="px-2 py-2">{{ __('fueltype') }}</th>
                        <th class="px-2 py-2">{{ __('fueltype1') }}</th>
                        <th class="px-2 py-2">{{ __('mpgdata') }}</th>
                        <th class="px-2 py-2">{{ __('phevblended') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($cars as $car)
                        @foreach ($car->models as $model)
                            <tr>
                                <td class="border px-2 py-2">{{ $car->car_name }}</td>
                                <td class="border px-2 py-2">{{ $model->model }}</td>
                                <td class="border px-2 py-2">{{ $model->cylinders }}</td>
                                <td class="border px-2 py-2">{{ $model->drive }}</td>
                                <td class="border px-2 py-2">{{ $model->eng_dscr }}</td>
                                <td class="border px-2 py-2">{{ $model->fueltype }}</td>
                                <td class="border px-2 py-2">{{ $model->fueltype1 }}</td>
                                <td class="border px-2 py-2">{{ $model->mpgdata }}</td>
                                <td class="border px-2 py-2">{{ $model->phevblended }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
