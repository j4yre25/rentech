<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'government_id_path',
        'selfie_path',
        'payout_type',
        'gcash_number',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
