<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function list()
    {
        $customers = Customer::get();

        return response()->json([
            'customers' => $customers,
        ]);
    }

    public function listWithOrders()
    {

        $customers = Customer::withCount('customerOrders')->get();

        return response()->json([
            'customers' => $customers
        ]);
    }

    public function create(Request $request)
    {

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'fb_account_link' => $request->fbLink,
            'created_at' => Carbon::now()
        ];

        Customer::create($data);

        $customers = Customer::get();

        $autoSelectId = Customer::where('name', '=', $request->name)->orWhere('phone', '=', $request->phone)->first()->id;

        return response()->json([
            'status' => 'success',
            'customers' => $customers,
            'autoSelectId' => $autoSelectId
        ]);
    }


    public function update(Request $request) {
        logger($request->toArray());

        Customer::where('id', '=', $request->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'fb_account_link' => $request->fb_account_link
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
