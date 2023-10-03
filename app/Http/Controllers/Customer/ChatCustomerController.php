<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Chat;
use App\Models\Customer;

use App\Traits\ChatsTrait;

class ChatCustomerController extends Controller
{

    use ChatsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(User $user)
    // {
    //     $msgs = DB::table('chats')
    //             ->join('user_customer_chat', 'chats.id', '=', 'user_customer_chat.chat_id')
    //             ->join('customers', 'user_customer_chat.customer_id', '=', 'customers.id')
    //             ->join('users', 'user_customer_chat.user_id', '=', 'users.id')
    //             ->select(
    //                 'chats.*',
    //                 'customers.*',
    //                 'users.*',)
    //             ->where('customers.id', Auth::guard('customer')->user()->id)
    //             ->where('users.id', $user->id)->get();

    //     $data = [
    //         'title' => 'Chat',
    //         'mechanic' => $user,
    //         'msgs' => $msgs,
    //     ];

    //     return view('customer.chat.chat', $data);
    // }

    public function getAllMessages()
    {
        $users = User::with('chats', 'chats.customers')->get();


        // dd($customers);

        $data = [
            'title' => 'Chat',
            'users' => $users,
        ];

        return view('customer.chat.msg', $data);
    }
}
