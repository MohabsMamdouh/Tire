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
        <div class="flex flex-col h-screen w-5/6 mx-auto p-3">
            <div class="chat hidden">
                <div id="cInfo" class="top bg-gray-300 m-auto p-2">
                    <div>
                        <i class="fas fa-user"></i>
                        <p></p>
                        <small class="address"></small><br>
                        <small class="phone"></small>
                    </div>

                </div>
                <hr class="border-2 border-gray-500 dark:border-gray-200 rounded-lg">

                <div id="msgs" class="messages w-full bg-gray-100 m-auto p-2" style="overflow: scroll">
                    <div id="messagesShow"></div>
                </div>

                <div class="bottom">
                    <form>
                        <div class="usr">
                            <input type="hidden" name="customer_id" id="customer_id" value="">
                        </div>
                        <input class="w-full bg-gray-300 py-5 px-3" name="message" id="message" type="text" placeholder="type your message here..."  />
                        <button type="submit"></button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end message -->
    </div>
</div>


<script>
    $(document).ready(function () {

        setInterval(function() {
            if ($('#cid').val() != undefined) {
                getMessages($('#cid').val());
            }
        }, 5000);

        $('.userList-item').on('click', function() {
            var cidValue = $(this).find('.cid').val();
            getMessages(cidValue);
            customerInfo(cidValue);
            $('.chat').removeClass('hidden');
            $("form .usr").html('<input type="hidden" name="cid" id="cid" value="'+ cidValue +'">');
        });

        $('#MessageSend').click(function (e) {
            e.preventDefault();
            send($('#customer_id').val());
        });

        $("form").submit(function (e) {
            e.preventDefault();
            send($("#cid").val());
        });

        $("form").submit(function (e) {
            e.preventDefault();
            send($("#cid").val());
        });

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetch_customers(query);
        });
    });
</script>
