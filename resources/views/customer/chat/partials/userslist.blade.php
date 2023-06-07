@foreach ($users as $user)
    <div class="userList-item flex flex-row py-4 px-2 justify-center cursor-pointer hover:bg-gray- items-center border-b-2 dark:border-gray-400">
        <div class="w-50 dark:text-white border border-gray-300 rounded-full mx-auto bg-gray-700 text-center p-2">
             <i class="fas fa-user"></i>
        </div>
        <div class="w-full ml-2">
            {{-- <div class="hidden" id="cid">{{ $customer->id }}</div> --}}
            <input type="hidden" id="cid" name="cid" value="{{ $user->id }}">
            <div id="Cname" class="text-lg font-semibold dark:text-gray-300">{{ $user->fname }}</div>
        </div>
    </div>
@endforeach
