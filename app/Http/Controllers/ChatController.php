<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('chats', 'chats.users')->whereHas('chats', function ($query) {
                            $query->whereHas('users', function ($query) {
                                $query->where('users.id', Auth::user()->id);
                            });
                        })->get();


        // dd($customers);

        $data = [
            'title' => 'Chat',
            'customers' => $customers,
        ];

        return view('chats.chat', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLiveMessages(User $user, Customer $customer, $sender='1')
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
            if ($msg->sender == 'customer') {
                $result .= $head1 . $icon . $msgOpen1 . $msg->message . $msgClose . $usr . $customer->customer_fname . $usrTime . $msg->created_at . $usrend . $headClose;
            } else {
                $result .= $head2 . $usr . 'YOU' . $usrTime . $msg->created_at . $usrend . $msgOpen2 . $msg->message . $msgClose . $headClose;
            }
        }

        $result .= '<input type="hidden" id="customer_id" value="'.$customer->id.'">';


        $result .= '<script>
            getMessages('.$customer->id.')z;
        </script>';

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $chat->users()->attach(Auth::user()->id, ['customer_id' => $customer->id]);

        return $request['msg'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRequest  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
