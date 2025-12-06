<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Carbon;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'duration_days',
        'daily_rate',
        'total_amount',
        'status',
        'returned_at',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'approved', 'active']);
    }

    public function scopeHistorical($query)
    {
        return $query->whereIn('status', ['completed', 'cancelled', 'returned']);
    }

    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        return Carbon::now()->startOfDay()->diffInDays($this->end_date, false);
    }
}