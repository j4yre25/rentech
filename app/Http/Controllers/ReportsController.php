<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rentee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $products = Product::all();
        $categories = Category::all();
        $rentees = Rentee::all();

        return Inertia::render('Admin/Reports', [
            'orders' => $orders,
            'products' => $products,
            'categories' => $categories,
            'rentees' => $rentees,
        ]);
    }
}