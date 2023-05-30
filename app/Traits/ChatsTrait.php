<?php

namespace App\Traits;

use Illuminate\Http\Request;

// Models
use App\Models\Chat;
use App\Models\Customer;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// date_default_timezone_set('Africa/Cairo');


/**
 * Function fot storing car and its models and specs in db
 */
trait ChatsTrait
{
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function LoadMessages(User $user, Customer $customer, $sender)
    {
        $msgs = DB::table('chats')
                ->join('user_customer_chat', 'chats.id', '=', 'user_customer_chat.chat_id')
                ->join('customers', 'user_customer_chat.customer_id', '=', 'customers.id')
                ->join('users', 'user_customer_chat.user_id', '=', 'users.id')
                ->select(
                    'chats.*',
                    'customers.*',
                    'users.*',)
                ->where('customers.id', $customer->id)
                ->where('users.id', $user->id)->get();

        $result = "";

        $head1 = '<div class="flex items-center justify-start mb-4">';

        $head2 = '<div class="flex items-center justify-end mb-4">';

        $icon = '<div class="rounded-full bg-gray-300 h-8 w-8 flex items-center justify-center mr-4">
                    <span class="font-bold text-sm"><i class="fas fa-user"></i></span>
                </div>';

        $msgOpen1 = '<div class="bg-gray-200 rounded-lg p-3 mb-2 max-w-xs"><p>';
        $msgClose = '</p></div>';

        $msgOpen2 = '<div class="bg-blue-500 rounded-lg p-3 ml-4 max-w-xs text-white"><p>';

        $usr = '<div class="flex flex-col ml-2"><span class="font-bold text-sm">';
        $usrTime = '</span><span class="text-xs text-gray-500">';
        $usrend = '</span></div>';

        $headClose = '</div>';

        if (count($msgs) == 0) {
            return $result;
        }

        foreach ($msgs as $msg) {
            if ($msg->sender != $sender) {
                $result .= $head1 . $icon . $msgOpen1 . $msg->message . $msgClose . $usr . $customer->customer_fname . $usrTime . str_replace('-', ' ', date('F j, Y, g:i a', strtotime($msg->created_at))) . $usrend . $headClose;
            } else {
                $result .= $head2 . $usr . 'YOU' . $usrTime . str_replace('-', ' ', date('F j, Y, g:i a', strtotime($msg->created_at))) . $usrend . $msgOpen2 . $msg->message . $msgClose . $headClose;
            }

        }

        return $result;
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
}
