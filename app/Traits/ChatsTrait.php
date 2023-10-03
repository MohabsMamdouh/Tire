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
    public function LoadMessages(User $user, Customer $customer)
    {
        $msgs = DB::table('chats')
                ->join('user_customer_chat', 'chats.id', '=', 'user_customer_chat.chat_id')
                ->join('customers', 'user_customer_chat.customer_id', '=', 'customers.id')
                ->join('users', 'user_customer_chat.user_id', '=', 'users.id')
                ->select(
                    'chats.*',
                    'customers.customer_fname',
                    'users.fname',)
                ->where('customers.id', $customer->id)
                ->where('users.id', $user->id)->get();
        return $msgs;
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
