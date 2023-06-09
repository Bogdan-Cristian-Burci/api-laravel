<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        return Training::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'training_category_id' => ['required', 'integer'],
            'training_type_id' => ['required', 'integer'],
        ]);

        return Training::create($request->validated());
    }

    public function show(Training $training)
    {
        return $training;
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'training_category_id' => ['required', 'integer'],
            'training_type_id' => ['required', 'integer'],
        ]);

        $training->update($request->validated());

        return $training;
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return response()->json();
    }
}
