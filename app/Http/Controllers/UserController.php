<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Transformers\User\UserSummaryTransformer;
use App\Transformers\UserTrainingsTransformer;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function update(UpdateUserRequest $request){

        $user=$request->user();

        $user->update($request->all());

        return $this->successResponse(null, 'User updated with success');

    }
    public function getUser(){

        $user = \request()->user();
        $data = fractal($user, new UserSummaryTransformer());

        return $this->successResponse($data,"User data found with success");
    }

    public function getSummary(Request $request){
        $authenticatedUser = $request->user();

        $quizzes = $authenticatedUser->quizzes;
        $quizzesCollection = collect();

        if(count($quizzes)>0){
            foreach ($quizzes as $quiz){
                $totalResponses = $quiz->responses;
                $quizzesCollection->push([
                    'id'=>$quiz->id,
                    'total_questions'=>$quiz->questions->count(),
                    'total_responses'=>$totalResponses->count(),
                    'correct_answers'=>$totalResponses->filter(function($answer){
                        return (boolean)$answer->is_correct = true;
                    })->count()
                ]);
            }
        }

        return $this->successResponse($quizzesCollection,'Summary found with success');
    }

    public function getTrainings(){

        $user = \request()->user();
        $data = fractal($user, new UserTrainingsTransformer());

        return $this->successResponse($data,'Trainings found with success');
    }
}
