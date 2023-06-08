<!-- component -->
<!-- This is an example component -->
<div class="container mx-auto shadow-lg rounded-lg">
    <!-- Chatting -->
    <div class="flex flex-row justify-between">
        <!-- chat list -->
        <div class="flex flex-col w-2/5 border-r-2 dark:border-gray-400 h-screen">

            <!-- search compt -->
            {{-- <div class="border-b-2 dark:border-gray-400 py-4 px-2">
                <input
                type="text"
                placeholder="search chatting"
                class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                />
            </div> --}}
            <!-- end search compt -->

            <!-- user list -->
            <div id="userList">
                <div class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                    @include('chats.partials.customerslist')
                </div>
            </div>
            <!-- end user list -->
        </div>
        <!-- end chat list -->

        <!-- message -->
        <div class="w-full px-5 flex flex-col justify-between h-screen" id="chat">
                <div class="flex flex-col h-screen">
                    <div class="flex-1 overflow-y-auto px-4 py-6" id="message-overflow">
                      <div class="flex flex-col" id="messagesShow">
                      </div>
                    </div>
                    <div class="controller hidden mt-2 mb-5">
                        <div class="flex items-center">
                            <input type="text" placeholder="Type your message here" id="msg"  class="flex-1 appearance-none border border-gray-300 rounded-lg py-2 px-4 mr-4 focus:outline-none focus:border-blue-500">
                            <button type="submit" id="MessageSend" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg py-2 px-4 focus:outline-none">Send</button>
                        </div>
                    </div>
                </div>



            {{-- <div class="flex flex-col h-screen">
                <div class="flex-1 overflow-y-auto px-4 py-6">
                  <div class="flex flex-col">



                    <div class="flex items-center justify-start mb-4">
                      <div class="rounded-full bg-gray-300 h-8 w-8 flex items-center justify-center mr-4">
                        <span class="font-bold text-sm"><i class="fas fa-user"></i></span>
                      </div>
                      <div class="bg-gray-200 rounded-lg p-3 mb-2 max-w-xs">
                        <p>Hello, how can I help you today?</p>
                      </div>
                      <div class="flex flex-col ml-2">
                        <span class="font-bold text-sm">Alice</span>
                        <span class="text-xs text-gray-500">2:30 PM</span>
                      </div>

                    </div>





                    <div class="flex items-center justify-end mb-4">


                      <div class="flex flex-col ml-2">
                        <span class="font-bold text-sm">You</span>
                        <span class="text-xs text-gray-500">2:35 PM</span>
                      </div>
                      <div class="bg-blue-500 rounded-lg p-3 ml-4 max-w-xs">
                        <p>Hi Alice, I'm having trouble with my account.</p>
                      </div>
                    </div>


                  </div>
                </div>
                <form class="px-4 py-3">
                  <div class="flex items-center">
                    <input type="text" placeholder="Type your message here" class="flex-1 appearance-none border border-gray-300 rounded-lg py-2 px-4 mr-4 focus:outline-none focus:border-blue-500">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg py-2 px-4 focus:outline-none">Send</button>
                  </div>
                </form>
            </div> --}}


        </div>
        <!-- end message -->

        <div id="CustomerInfo" class="w-2/5 border-l-2 dark:border-gray-400 px-5">
        </div>
    </div>
</div>


