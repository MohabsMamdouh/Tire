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
        $result .= '<div id="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.940537254977!2d-122.43129768566308!3d37.77397297762194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085806c7d9e7d09%3A0x4a501367f076ad3a!2sGolden%20Gate%20Bridge!5e0!3m2!1sen!2sus!4v1622115157889!5m2!1sen!2sus&center='.$user->addresses[0]->address_latitude.','.$user->addresses[0]->address_longitude.'&zoom=12&maptype=satellite"
                width="200" height="150"
                style="border:0;" loading="lazy">
            </iframe>
            <div>'.$user->addresses[0]->address_address.' <a target="_blank" href="https://www.google.com/maps/search/?api=1&query='.$user->addresses[0]->address_latitude.','.$user->addresses[0]->address_longitude.'"><i class="fa-solid fa-map"></i></a></div>

        </div>';

        // dd($user->addresses);
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->created_at.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->phone.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$user->email.'</div>';
        $result .= '<div class="flex flex-col dark:text-gray-200"><button id="pickMe" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Pcik Me</button></div>';
        $result .= '</div>';



        $result .= '<script>
        $("#pickMe").on("click", function() {
            console.log("xxx");
            console.log("'.Auth::guard('customer')->user()->customer_fname.'");
            $("#pickMe").load("'.route('customer.pick.store', ['user' => $user->id, 'customer' => Auth::guard('customer')->user()->id]).'","data", function (response, status, request) {
                // console.log(response);
            });
        });
        </script>';

        return $result;
    }
}
