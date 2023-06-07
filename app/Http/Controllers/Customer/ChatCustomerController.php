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

    public function getAllMessages()
    {
        $users = User::with('chats', 'chats.customers')->whereHas('chats', function ($query) {
            $query->whereHas('customers', function ($query) {
                $query->where('customers.id', Auth::guard("customer")->user()->id);
            });
        })->get();


        // dd($customers);

        $data = [
            'title' => 'Chat',
            'users' => $users,
        ];

        return view('customer.chat.All-chats', $data);
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
        $output = $this->LoadMessages($user, $customer, 'customer');

        $output .= '<input type="hidden" id="user_id" value="'.$user->id.'">';

        $output .= '<script>
            getMessages('.$user->id.');
        </script>';

        return $output;
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
