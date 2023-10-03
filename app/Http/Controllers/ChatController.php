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

use App\Traits\ChatsTrait;

class ChatController extends Controller
{
    use ChatsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('chats', 'chats.users')->get();

        $data = [
            'title' => 'Chat',
            'customers' => $customers,
        ];

        return view('chats.chat', $data);
    }
}
