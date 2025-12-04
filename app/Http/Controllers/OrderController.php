<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
   public function index(Request $request)
{
    $orders = Order::query()
        ->when($request->customer, function ($query, $customer) {
            $query->where('customer_name', 'like', "%$customer%");
        })
        ->when($request->payment_status, function ($query, $paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        })
        ->when($request->order_status, function ($query, $orderStatus) {
            $query->where('order_status', $orderStatus);
        })
        ->paginate(15);

    if ($request->expectsJson()) {
        return response()->json($orders);
    }

    return Inertia::render('Admin/Orders', [
        'orders' => $orders,
        'filters' => $request->only(['customer', 'payment_status', 'order_status']),
    ]);
}
}