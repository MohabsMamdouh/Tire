<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Chat;
use App\Models\Customer;

class ChatCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $msgs = DB::table('chats')
                ->join('user_customer_chat', 'chats.id', '=', 'user_customer_chat.chat_id')
                ->join('customers', 'user_customer_chat.customer_id', '=', 'customers.id')
                ->join('users', 'user_customer_chat.user_id', '=', 'users.id')
                ->select(
                    'chats.*',
                    'customers.*',
                    'users.*',)
                ->where('customers.id', Auth::guard('customer')->user()->id)
                ->where('users.id', $user->id)->get();

        $data = [
            'title' => 'Chat',
            'mechanic' => $user,
            'msgs' => $msgs,
        ];

        return view('customer.chat.chat', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Customer $customer)
    {
        $chat = new Chat();
        $chat->message = $request->get('msg');
        $chat->sender = $request->get('sender');

        $chat->save();

        $chat->users()->attach($user->id, ['customer_id' => $customer->id]);

        return $request['msg'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLiveMessages(User $user, Customer $customer)
    {
        $msgs = DB::table('chats')
                ->join('user_customer_chat', 'chats.id', '=', 'user_customer_chat.chat_id')
                ->join('customers', 'user_customer_chat.customer_id', '=', 'customers.id')
                ->join('users', 'user_customer_chat.user_id', '=', 'users.id')
                ->select(
                    'chats.*',
                    'customers.*',
                    'users.*',)
                ->where('customers.id', Auth::guard('customer')->user()->id)
                ->where('users.id', $user->id)->get();

        $result = "";

        if (count($msgs) == 0) {
            return $result;
        }

        $head1 = '<div class="chat-message">
                    <div class="flex items-end">
                        <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                            <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">';

        $head2 = '<div class="chat-message">
                    <div class="flex items-end justify-end">
                        <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                            <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">';

        $tail = '</span></div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-1">
                        </div>
                    </div>';

        foreach ($msgs as $msg) {
            if ($msg->sender == 'customer') {
                $result .= $head2 . $msg->message;
            } else {
                $result .= $head1 . $msg->message;
            }

            $result .= $tail;
        }
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
