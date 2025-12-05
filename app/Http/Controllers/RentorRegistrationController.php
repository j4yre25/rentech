<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewRentor;
use Illuminate\Http\Request;

class RentorRegistrationController extends Controller
{
    protected $createNewRentor;

    public function __construct(CreateNewRentor $createNewRentor)
    {
        $this->createNewRentor = $createNewRentor;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // Call the CreateNewRentor action
        $user = $this->createNewRentor->create($input);

        return response()->json(['message' => 'Rentor registered successfully!', 'user' => $user], 201);
    }
}