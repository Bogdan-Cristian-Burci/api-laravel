<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Transformers\Quiz\QuizSummaryTransformer;
use App\Transformers\User\CreateUserTransformer;
use App\Transformers\User\LoginTransformer;
use App\Transformers\User\UserSummaryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends ApiController
{
    public function register(CreateUserRequest $request)
    {
            $user = User::create(['name'=>$request->input('name'),'email'=>$request->input('email'), 'password'=>Hash::make($request->input('password'))]);

            $data = fractal($user, new CreateUserTransformer())
                ->toArray();

            return $this->successResponse($data,'User created successfully',201);
    }

    public function login(LoginUserRequest $request){

        try{
            $user = User::where('email',$request->input('email'))->first();
            \Log::info('request received from '.json_encode($user));
            if(Hash::check($request->input('password'), $user->password)){

                $token = $user->createToken($request->input('device'))->plainTextToken;
                \Log::info('token created '.json_encode($token));
                $data = fractal($user, new LoginTransformer())->addMeta([
                    'token'=>$token
                ])->toArray();

                return $this->successResponse($data);
            }
        }catch(\Exception $e){
            \Log::error('Error on login: ' . $e->getMessage());
            abort(500, 'Could not login your user');
        }
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

}
