{{ count($msgs) }}

<div class="chat-message">
    <div class="flex items-end">
       <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
          <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">Can be verified on any platform using docker</span></div>
       </div>
       <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-1">
    </div>
</div>
<div class="chat-message">
    <div class="flex items-end justify-end">
       <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
          <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">Your error message says permission denied, npm global installs must be given root privileges.</span></div>
       </div>
       <img src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-2">
    </div>
</div>

@foreach ($msgs as $msg)
<div class="chat-message">
    <div class="flex items-end @if ($msg->sender == 'customer') justify-end @else  @endif">
       <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
          <div>
            <span style="@if ($msg->sender == 'customer') background: #3B82F6;color: #fff; @else background: #d1d1d1;color: #a39696; @endif"
                class="px-4 py-2 rounded-lg inline-block rounded-br-none">
                {{ $msg->message }}
            </span>
        </div>
       </div>
       <img src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-2">
    </div>
</div>
@endforeach
