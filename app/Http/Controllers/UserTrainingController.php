<?php

namespace App\Http\Controllers;

use App\Models\UserTraining;
use Illuminate\Http\Request;

class UserTrainingController extends Controller
{
    public function index()
    {
        return UserTraining::all();
    }

    public function store(Request $request)
    {
        $request->validate([

        ]);

        return UserTraining::create($request->validated());
    }

    public function show(UserTraining $userTraining)
    {
        return $userTraining;
    }

    public function update(Request $request, UserTraining $userTraining)
    {
        $request->validate([

        ]);

        $userTraining->update($request->validated());

        return $userTraining;
    }

    public function destroy(UserTraining $userTraining)
    {
        $userTraining->delete();

        return response()->json();
    }
}
