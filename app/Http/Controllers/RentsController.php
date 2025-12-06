<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rent;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RentsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeRents = Rent::query()
            ->active()
            ->where('user_id', $user->id)
            ->with(['product', 'product.category'])
            ->latest('start_date')
            ->get()
            ->map(function (Rent $rent) {
                $product = $rent->product;

                return [
                    'id' => $rent->id,
                    'order_id' => $rent->id,
                    'product_id' => optional($product)->id,
                    'product_name' => optional($product)->name ?? 'Unknown Product',
                    'product_image' => optional($product)->image_url ?? optional($product)->thumbnail_url ?? null,
                    'status' => ucfirst($rent->status ?? 'pending'),
                    'start_date' => optional($rent->start_date)?->toDateString(),
                    'end_date' => optional($rent->end_date)?->toDateString(),
                    'total_amount' => $rent->total_amount ?? 0,
                    'duration' => $rent->duration_days ?? optional($rent->start_date)?->diffInDays(optional($rent->end_date)) ?? 0,
                    'daily_rate' => $rent->daily_rate ?? 0,
                    'days_remaining' => $rent->days_remaining !== null ? max($rent->days_remaining, 0) : null,
                ];
            });

        $rentHistory = Rent::query()
            ->historical()
            ->where('user_id', $user->id)
            ->with(['product', 'product.category'])
            ->latest('end_date')
            ->get()
            ->map(function (Rent $rent) {
                $product = $rent->product;

                return [
                    'id' => $rent->id,
                    'order_id' => $rent->id,
                    'product_id' => optional($product)->id,
                    'product_name' => optional($product)->name ?? 'Unknown Product',
                    'product_image' => optional($product)->image_url ?? optional($product)->thumbnail_url ?? null,
                    'status' => ucfirst($rent->status ?? 'completed'),
                    'start_date' => optional($rent->start_date)?->toDateString(),
                    'end_date' => optional($rent->end_date)?->toDateString(),
                    'returned_date' => optional($rent->returned_at)?->toDateString(),
                    'total_amount' => $rent->total_amount ?? 0,
                    'duration' => $rent->duration_days ?? optional($rent->start_date)?->diffInDays(optional($rent->end_date)) ?? 0,
                    'daily_rate' => $rent->daily_rate ?? 0,
                    'review_submitted' => false,
                ];
            });

        return Inertia::render('Customer/RentsTab', [
            'activeRents' => $activeRents,
            'rentHistory' => $rentHistory,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $user = Auth::user();

        $data = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $start = Carbon::parse($data['start_date'])->startOfDay();
        $end = Carbon::parse($data['end_date'])->startOfDay();

        $durationDays = max(1, $start->diffInDays($end) + 1);

        $dailyRate = $product->price_per_day ?? $product->daily_rate ?? $product->price ?? 0;
        $totalAmount = $dailyRate * $durationDays;

        Rent::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'duration_days' => $durationDays,
            'daily_rate' => $dailyRate,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('rents.index')->with('success', 'Rental request submitted.');
    }
}