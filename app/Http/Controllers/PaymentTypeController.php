<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function list() {
        $paymentTypes = PaymentType::get();

        return response()->json([
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function create(Request $request) {
        logger($request->toArray());
        PaymentType::create([
            'name' => $request->name
        ]);
        $paymentTypes = PaymentType::get();
        $selectedId = PaymentType::where('name' , '=', $request->name)->first()->id;

        return response()->json([
            'status' => 'success',
            'paymentTypes' => $paymentTypes,
            'selectedId' => $selectedId
        ]);
    }
}
