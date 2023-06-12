<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (isset($user->addresses[0])) {
            $result .= '<div id="map">
                <div><a target="_blank" href="https://www.google.com/maps/search/?api=1&query='.$user->addresses[0]->address_latitude.','.$user->addresses[0]->address_longitude.'">'.$user->addresses[0]->address_address.' <i class="fa-solid fa-map"></i></a></div>
            </div>';
        }

        $result .= '<div class="font-semibold py-4 dark:text-gray-200"><b>'.__('Joined since: ').'</b>'.str_replace('-', ' ', date('F j, Y', strtotime($user->created_at))).'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->phone.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->email.'</div>';
        $result .= '</div>';

        return $result;
    }
}
