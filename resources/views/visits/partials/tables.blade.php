<div class="container pt-8 mx-auto" x-data="{ myForData: sourceData }">
    <div class="dark:text-gray-200 shadow">
        <div class="flex flex-col justify-center">
            <table class="table-fixed">
                <thead class="dark:bg-slate-500">
                    <tr>
                        <th class="px-2 py-2">{{ __('Customer Name') }}</th>
                        <th class="px-2 py-2">{{ __('Car') }}</th>
                        <th class="px-2 py-2">{{ __('Model') }}</th>
                        <th class="px-2 py-2">{{ __('Status') }}</th>
                        <th class="px-2 py-2">{{ __('Mechanic') }}</th>
                        <th class="px-2 py-2">{{ __('Date') }}</th>
                        <th class="px-2 py-2">{{ __('Edit') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($visits as $visit)
                        <tr>
                            <td class="border px-2 py-2 text-center">{{ $visit->customer }}</td>
                            <td class="border px-2 py-2 text-center">{{ $visit->car_name }}</td>
                            <td class="border px-2 py-2 text-center">{{ $visit->model }}</td>
                            <td class="border px-2 py-2 text-center">{{ $visit->reason }}</td>
                            <td class="border px-2 py-2 text-center">{{ $visit->mechanic }}</td>
                            <td class="border px-2 py-2 text-center">
                                {{ str_replace('-', ' ', date('F j, Y, g:i A', strtotime($visit->created_at))) }}
                            </td>
                            <td class="border px-2 py-2 text-center">
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
