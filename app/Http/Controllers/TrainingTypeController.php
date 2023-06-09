<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    public function index()
    {
        return TrainingType::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
        ]);

        return TrainingType::create($request->validated());
    }

    public function show(TrainingType $trainingType)
    {
        return $trainingType;
    }

    public function update(Request $request, TrainingType $trainingType)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
        ]);

        $trainingType->update($request->validated());

        return $trainingType;
    }

    public function destroy(TrainingType $trainingType)
    {
        $trainingType->delete();

        return response()->json();
    }
}
