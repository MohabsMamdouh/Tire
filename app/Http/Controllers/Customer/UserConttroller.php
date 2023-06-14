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

    public function searchChat(Request $request)
    {
        $output = '';
        $q = $request->get('query');

        if($q != '')
        {
            $data = User::where('fname', 'like', '%'.$q.'%')->get();
        } else {
            $data = User::all();
        }

        $head = '<div class="userList-item-';
        $c_head = ' flex flex-row py-4 px-2 justify-center cursor-pointer hover:bg-gray- items-center border-b-2 dark:border-gray-400">
                    <div class="w-50 dark:text-white border border-gray-300 rounded-full mx-auto bg-gray-700 text-center p-2">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="w-full ml-2">';

        $cid = '<input type="hidden" class="cid" name="cid" value="';

        $cName = '"><div id="Cname" class="text-lg font-semibold dark:text-gray-300">';

        $tail = '</div></div></div>';

        if (count($data) > 0) {
            foreach ($data as $user) {
                $output .= $head . $user->id . $c_head . $cid . $user->id . $cName . $user->fname . $tail;
                $output .= "
                    <script>
                        $(document).ready(function () {

                            $('.userList-item-".$user->id."').on('click', function() {
                                getMessages('".$user->id."');
                                userInfo('".$user->id."');
                                $('.controller').removeClass('hidden');
                            });
                        });
                    </script>";
            }
        } else {
            $output .= $head . $c_head . $cid . $cName . "Not Found" . $tail;
        }

        return $output;
    }
}
