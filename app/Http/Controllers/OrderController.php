<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Order_Product;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class OrderController extends Controller
{
    public function create(Request $request)
    {

        $forOrderTable = [
            'customer_id' => $request->customer['id'],
            'payment_type_id' => $request->paymentType['id'],
            'status' => $request->status,
            'paid' => $request->paid,
            'total' => $request->total
        ];

        $newOrderId = Order::create($forOrderTable);
        $newOrderId = $newOrderId->id;



        foreach ($request->products as $item) {
            $data = [
                'order_id' => $newOrderId,
                'product_id' => $item['id'],
                'qty' => $item['qty']
            ];

            $productInstock = Product::where('id', '=', $item['id'])->first()->instock;

            Product::where('id', '=', $item['id'])->update([
                'instock' => $productInstock - $item['qty']
            ]);

            Order_Product::create($data);
        }
        return response()->json([
            'status' => 'A new order has been recorded.'
        ]);
    }

    public function list()
    {
        $orders = Order::select('orders.*', 'customers.name as customer_name', 'payment_types.name as payment_type')->leftJoin('customers', 'customers.id', 'orders.customer_id')->leftJoin('payment_types', 'payment_types.id', 'orders.payment_type_id')->get();

        $orderProducts = Order_Product::select('order__products.*', 'products.name as product_name', 'products.price', 'products.image')->leftJoin('products', 'products.id', 'order__products.product_id')->get();

        return response()->json([
            'orders' => $orders,
            'orderProducts' => $orderProducts
        ]);
    }

    public function update(Request $request)
    {
        logger($request);
        if (
            $request->paid == '' || $request->paid == null || !isset($request->paid)
        ) {
            Order::where('id', '=', $request->orderId)->update([
                'status' => $request->status
            ]);
        } elseif ($request->status == '' || $request->status == null || !isset($request->status)) {
            Order::where('id', '=', $request->orderId)->update([
                'paid' => $request->paid
            ]);
        } else {
            Order::where('id', '=', $request->orderId)->update([
                'paid' => $request->paid,
                'status' =>$request->status
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
