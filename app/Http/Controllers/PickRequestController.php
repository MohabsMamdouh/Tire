<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PickRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\CustomerCarInfo;
use App\Models\Customer;
use App\Models\Visit;



class PickRequestController extends Controller
{
    public function getNotification()
    {
        $lastHour = now()->subHour(); // get the timestamp for one hour ago
        $lastRecords = PickRequest::with('customer', 'customer.location')->whereBetween('created_at', [$lastHour, now()])->where('user_id', Auth::user()->id)->where('status', 'pending')->get(['*']);

        $output = "";

        $head = '<div class="fixed top-5 right-5 z-50 bg-blue-500 p-4 rounded">
                <p class="text-white font-bold">';
        $map = '<a target="_blank" href="https://www.google.com/maps/search/?api=1&query=';
        $endmap = '"><i class="fa-solid fa-map"></i></a>';
        $btnApprove = '</p><div class="flex flex-col"><a href="';
        $endbtnApprove = '" class="bg-white text-blue-500 px-4 py-2 m-1 mb-3 rounded">Approve</a>';

        $btnDecline = '<a href="';
        $endbtnDecline = '" class="bg-white text-red-500 px-4 py-2 m-1 rounded">Decline</a></div></div>';


        foreach ($lastRecords as $record) {
            $output .= $head . $record->customer->customer_fname . ' ';
            $output .= $map . $record->customer->location->latitude.','.$record->customer->location->longitude. $endmap;
            $output .= $btnApprove . route('picks.update', ['status' => 'approve', 'pickRequest' => $record->id]) . $endbtnApprove;
            $output .= $btnDecline . route('picks.update', ['status' => 'decline', 'pickRequest' => $record->id]) . $endbtnDecline;
        }

        return $output;
    }

    public function update($status, PickRequest $pickRequest)
    {
        if ($status == 'approve') {
            $pickRequest->status = $status;
            $pickRequest->save();

            $visit = new Visit();

            $car = CustomerCarInfo::where('customer_id', $pickRequest->customer_id)->first();

            $visit->customer_id = $pickRequest->customer_id;
            $visit->car_model_id = $car->model_id;
            $visit->reason = "Checkup";
            $visit->user_id = $pickRequest->user_id;
            $visit->save();

            return redirect(route('picks.approve', ['customer' => $pickRequest->customer_id, 'pickRequest' => $pickRequest->id]));

        } elseif ($status == 'decline') {
            $pickRequest->status = $status;
            $pickRequest->save();

            return redirect(route('dashboard'));
        }
    }

    public function approve(Customer $customer, PickRequest $pickRequest)
    {
        $customer->location;

        $data = [
            'customer' => $customer,
            'pickRequest' => $pickRequest,
            'title' => 'Approved Request',
        ];

        return view('picks.pick', $data);
    }

    public function done(PickRequest $pickRequest)
    {
        $pickRequest->status = 'Done';
        $pickRequest->save();

        return redirect(route('dashboard'));
    }
}
