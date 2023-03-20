<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="dark:text-gray-200 shadow">
        <div class="flex flex-col justify-center">
            <table class="table-fixed">
                <thead class="dark:bg-slate-500">
                    <tr>
                        <th class="px-2 py-2">{{ __('Customer Name') }}</th>
                        <th class="px-2 py-2">{{ __('Car') }}</th>
                        <th class="px-2 py-2">{{ __('Model') }}</th>
                        <th class="px-2 py-2">{{ __('Reason') }}</th>
                        <th class="px-2 py-2">{{ __('Stuff Member') }}</th>
                        <th class="px-2 py-2">{{ __('Date') }}</th>
                        <th class="px-2 py-2">{{ __('Edit') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($visits as $visit)
                        <tr>
                            <td class="border px-2 py-2">{{ $visit->customer }}</td>
                            <td class="border px-2 py-2">{{ $visit->car_name }}</td>
                            <td class="border px-2 py-2">{{ $visit->model }}</td>
                            <td class="border px-2 py-2">{{ $visit->reason }}</td>
                            <td class="border px-2 py-2">{{ $visit->mechanic }}</td>
                            <td class="border px-2 py-2">{{ $visit->created_at }}</td>
                            <td class="border px-2 py-2">
                                <a href="{{ route('visit.edit', ['id' => $visit->id]) }}"
                                    class="text-blue-400 underline">{{ _('Edit') }}</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
