<?php

namespace App\Http\Controllers;

use App\Models\TrainingCategory;
use App\Transformers\TrainingCategoryTransformer;
use Illuminate\Http\Request;

class TrainingCategoryController extends ApiController
{
    public function index()
    {
        $trainingCategories = TrainingCategory::all();

        $data = fractal($trainingCategories, new TrainingCategoryTransformer());

        return $this->successResponse($data,'Categories found with success');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
        ]);

        return TrainingCategory::create($request->validated());
    }

    public function show(TrainingCategory $trainingCategory)
    {
        return $trainingCategory;
    }

    public function update(Request $request, TrainingCategory $trainingCategory)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
        ]);

        $trainingCategory->update($request->validated());

        return $trainingCategory;
    }

    public function destroy(TrainingCategory $trainingCategory)
    {
        $trainingCategory->delete();

        return response()->json();
    }
}
