<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserConttroller extends Controller
{
    public function getUserInfo(User $user)
    {
        $user->addresses;
        $result = '<div class="flex flex-col dark:text-gray-200">
                        <div class="font-semibold text-xl py-4">';
        $result .= $user->fname;
        $result .= '</div>';
        $result .= 'map<img src="https://source.unsplash.com/L2cxSuKWbpo/600x600" class="object-cover rounded-xl h-64" alt="" />';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->created_at.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->phone.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->email.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->addresses[0]->address_address.'</div>';
        $result .= '</div>';

        return $result;
    }
}
