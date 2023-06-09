<!-- component -->
<!-- This is an example component -->
<div class="container shadow-lg rounded-lg">
    <!-- Chatting -->
    <div class="flex flex-row justify-between">
        <!-- chat list -->
        <div class="flex flex-col w-1/5 border-r-2 dark:border-gray-400 h-screen">

            <!-- search compt -->
            <div class="border-b-2 dark:border-gray-400 py-4 px-2">
                <input
                name="search" id="search" type="search"
                placeholder="Search Customers"
                class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                />
            </div>
            <!-- end search compt -->


            <!-- user list -->
            <div id="userList" class="overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                @include('chats.partials.customerslist')
            </div>

            <!-- end user list -->
        </div>
        <!-- end chat list -->

        <!-- message -->
        <div class="flex flex-col h-screen w-3/5 mx-auto p-3">
            <div id="messagesShow" class="flex-grow flex-end space-y-4 p-3 overflow-y-auto overflow-x-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                <!-- Render messages here -->
            </div>
            <div class="mt-4 controller hidden">
                <!-- Render input field here -->
                <input class="w-full bg-gray-300 py-5 px-3 rounded-xl" id="msg" type="text" placeholder="type your message here..."  />
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



        <div id="CustomerInfo" class="w-1/5 border-l-2 dark:border-gray-400 px-5">
        </div>


    </div>
    <!-- end message -->
</div>


<script>
    $(document).ready(function () {

        setInterval(function() {
            if ($('#customer_id').val() != undefined) {
                getMessages($('#customer_id').val());
            }
        }, 5000);

        $('.userList-item').on('click', function() {
            var cidValue = $(this).find('.cid').val();
            getMessages(cidValue);
            customerInfo(cidValue);
            $('.controller').removeClass('hidden');
        });

        $('#MessageSend').click(function (e) {
            e.preventDefault();
            send($('#customer_id').val());
        });

        $('input').on('keydown', function(event) {
            if (event.key === 'Enter') {
                send($('#customer_id').val());
            }
        });

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetch_customers(query);
        });
    });
</script>
