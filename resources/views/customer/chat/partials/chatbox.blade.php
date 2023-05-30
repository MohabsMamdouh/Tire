<!-- component -->
<!-- This is an example component -->
<div class="container shadow-lg rounded-lg" style="width: 900px;">
    <!-- Chatting -->
    <div class="flex flex-row justify-between">
        <!-- chat list -->
        {{-- <div class="flex flex-col w-2/5 border-r-2 dark:border-gray-400 overflow-y-auto">

            <!-- search compt -->
            <div class="border-b-2 dark:border-gray-400 py-4 px-2">
                <input
                type="text"
                placeholder="search chatting"
                class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                />
            </div>
            <!-- end search compt -->

            <!-- user list -->
            <div id="userList">
                @include('chats.partials.userlist')
            </div>
            <!-- end user list -->
        </div> --}}
        <!-- end chat list -->

        <!-- message -->
        <div class="w-3/4 px-5 flex flex-col justify-between h-screen">
            <div id="messagesShow" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch"></div>

            <div class="controller hidden">
                <div class="pt-5">
                    <input class="w-full bg-gray-300 py-5 px-3 rounded-xl" id="msg" type="text" placeholder="type your message here..."  />
                </div>
                <div class="w-full">
                    <button type="button" id="send" style="background: #3B82F6;"
                        class="inline-flex w-full items-center justify-center rounded-lg px-4 py-2 mt-1 mr-3 transition duration-500 ease-in-out text-white hover:bg-blue-400 dark:bg-blue-500 bg-blue-500 focus:outline-none">
                            <span class="font-bold">Send</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 ml-2 transform rotate-90">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                            </svg>
                    </button>
                </div>
            </div>

        </div>
        <!-- end message -->

        <div id="UserInfo" class="w-1/4 border-l-2 dark:border-gray-400 px-5">
        </div>
    </div>
</div>

 <script>
    const el = document.getElementById('messagesShow')
    el.scrollTop = el.scrollHeight

   $(document).ready(function () {
       $('#send').click(function (e) {
           e.preventDefault();
           send();
       });

       $('input').on('keydown', function(event) {
            if (event.key === 'Enter') {
                send();
            }
        });

        function send(cid) {
            $.ajax({
               type: "get",
               url: "{{ route('customer.chat.store.msg',['user' => $mechanic, 'customer' => Auth::guard('customer')->user()]) }}",
               data: {
                   msg: $('#msg').val(),
                   sender: 'customer',
               },
               success: function (response) {
                   // console.log(response);
                   getMessages();
                   $('#msg').val('');
               },
               error: function (request, error) {
                   console.log(arguments);
                   $('#msg').val('');
                   alert(" Can't do because: " + error);
               }
           });
        }

       getMessages();

       setInterval(function(){
           getMessages();
       }, 5000);

       function getMessages() {
           console.log('sss');
           $('#messagesShow').load(
              "{{ route('customer.chat.get.msg',['user' => $mechanic, 'customer' => Auth::guard('customer')->user()]) }}",
              function (response, status, request) {
                 $('#messagesShow').html(response);
                 $('#messagesShow').scrollTop($('#messagesShow')[0].scrollHeight);
           });
           $('.controller').removeClass('hidden');
           userInfo('{{ $mechanic->id }}');
       }

       function userInfo(user) {
            $('#UserInfo').load(
                "{{ route('customer.user.getUserInfo',['user' => ':user']) }}".replace(':user', user),
                function (response, status, request) {
                    $('#UserInfo').html(response);
            });
        }
   });
</script>
