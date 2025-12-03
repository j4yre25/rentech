<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Apple MacBook Air M2',
                'daily_rate' => 25,
                'emoji' => '💻',
                'reviews' => 124
            ],
            [
                'id' => 2,
                'name' => 'Canon EOS R6',
                'daily_rate' => 35,
                'emoji' => '📷',
                'reviews' => 98
            ],
            [
                'id' => 3,
                'name' => 'Sony WH-1000XM5',
                'daily_rate' => 8,
                'emoji' => '🎧',
                'reviews' => 210
            ],
            [
                'id' => 4,
                'name' => 'iPad Pro 12.9"',
                'daily_rate' => 20,
                'emoji' => '📱',
                'reviews' => 156
            ],
            [
                'id' => 5,
                'name' => 'DJI Mini 3 Pro',
                'daily_rate' => 30,
                'emoji' => '🚁',
                'reviews' => 87
            ],
            [
                'id' => 6,
                'name' => 'GoPro Hero 12',
                'daily_rate' => 12,
                'emoji' => '📹',
                'reviews' => 178
            ],
        ];
        
        return Inertia::render('HomePage', [
            'products' => $products
        ]);
    }
}