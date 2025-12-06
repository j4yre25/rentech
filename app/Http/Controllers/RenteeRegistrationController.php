<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewRentee;
use App\Models\Rentee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenteeRegistrationController extends Controller
{
    protected $createNewRentee;

    public function __construct(CreateNewRentee $createNewRentee)
    {
        $this->createNewRentee = $createNewRentee;
    }

    public function store(Request $request)
    {
        // validate all rentee-specific fields
        $validated = $request->validate([
            // Step 1
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],

            // Step 2
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string'],

            // Step 3
            'government_id' => ['required', 'file', 'max:10240'], // 10MB
            'selfie' => ['required', 'file', 'max:10240'],

            // Step 4 (optional)
            'payout_type' => ['nullable', 'in:gcash,bank'],
            'gcash_number' => ['nullable', 'string', 'max:50'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account_name' => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:100'],
        ]);

        // 1) Create the user (users table)
        $user = $this->createNewRentee->create($validated);

        // 2) Store files
        $governmentIdPath = null;
        $selfiePath = null;

        if ($request->hasFile('government_id')) {
            $governmentIdPath = $request->file('government_id')
                ->store('rentees/government_ids', 'public');
        }

        if ($request->hasFile('selfie')) {
            $selfiePath = $request->file('selfie')
                ->store('rentees/selfies', 'public');
        }

        // 3) Create associated Rentee record (rentees table)
        Rentee::create([
            'user_id' => $user->id,
            'name' => $validated['name'],          // also store name here
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'government_id_path' => $governmentIdPath,
            'selfie_path' => $selfiePath,
            'payout_type' => $validated['payout_type'] ?? null,
            'gcash_number' => $validated['gcash_number'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_name' => $validated['bank_account_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
        ]);

        // Redirect to email confirmation page
        return redirect()->route('email.confirm.show', [
            'email' => $user->email,
        ]);
    }
}