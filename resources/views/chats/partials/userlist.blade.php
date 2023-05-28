@foreach ($customers as $customer)
    <div id="userList-item" class="flex flex-row py-4 px-2 justify-center cursor-pointer hover:bg-gray- items-center border-b-2 dark:border-gray-400">
        <div class="w-50 dark:text-white border border-gray-300 rounded-full mx-auto bg-gray-700 text-center p-2">
             <i class="fas fa-user"></i>
        </div>
        <div class="w-full">
            {{-- <div class="hidden" id="cid">{{ $customer->id }}</div> --}}
            <input type="hidden" id="cid" name="cid" value="{{ $customer->id }}">
            <div id="Cname" class="text-lg font-semibold dark:text-gray-300">{{ $customer->customer_fname }}</div>
            <span class="text-gray-500">Pick me at 9:00 Am</span>
        </div>
    </div>
@endforeach
