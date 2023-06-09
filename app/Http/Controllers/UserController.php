<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ValidateTokenRequest;
use App\Models\PasswordReset;
use App\Models\Training;
use App\Models\User;
use App\Models\UserTraining;
use App\Notifications\PasswordResetNotification;
use App\Transformers\User\CreateUserTransformer;
use App\Transformers\User\LoginTransformer;
use App\Transformers\User\UserSummaryTransformer;
use App\Transformers\UserTrainingsTransformer;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;


class UserController extends ApiController
{
    public function register(CreateUserRequest $request)
    {
            $user = User::create(['name'=>$request->input('name'),'email'=>$request->input('email'), 'password'=>Hash::make($request->input('password'))]);

            $availableTrainings = Training::all();

            foreach ($availableTrainings as $training){

                UserTraining::create([
                    'training_id'=>$training->id,
                    'user_id'=>$user->id,
                    'active'=>false,
                    'expire_at'=>null
                ]);
            }

            $data = fractal($user, new CreateUserTransformer())
                ->toArray();

            return $this->successResponse($data,'User created successfully',201);
    }

    public function login(LoginUserRequest $request){

        try{
            $user = User::where('email',$request->input('email'))->first();

            if(Hash::check($request->input('password'), $user->password)){

                $token = $user->createToken($request->input('device'))->plainTextToken;

                $data = fractal($user, new LoginTransformer())->addMeta([
                    'token'=>$token
                ])->toArray();

                return $this->successResponse($data);
            }
        }catch(\Exception $e){
            \Log::error('Error on login: ' . $e->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request){

        $user = User::where('email',$request->input('email'))->first();

        //Generate 4 digit random token
        $resetPasswordToken = str_pad(random_int(1,9999),4,'0', STR_PAD_LEFT);

        $userPassResetRecord = PasswordReset::where('email', $user->email)->first();

        if(!$userPassResetRecord){
            PasswordReset::create([
                'email'=>$user->email,
                'token'=>$resetPasswordToken
            ]);
        }else{
            $userPassResetRecord->update([
                'email'=>$user->email,
                'token'=>$resetPasswordToken
            ]);
        }

        $user->notify(
            new PasswordResetNotification(
                $resetPasswordToken
            )
        );

        return $this->successResponse(null,'A code has been sent to your email address.');

    }

    public function validateToken(ValidateTokenRequest $request){

        $user = User::where('email',$request->input('email'))->first();

        $userPassResetRecord = PasswordReset::where('email', $user->email)->first();

        if($userPassResetRecord->token == $request->input('token')){
            $userPassResetRecord->validated = true;
            $userPassResetRecord->save();

            return $this->successResponse(null,'Token validated with success');
        }

        return $this->errorResponse(400,'Token does dot match');
    }

    /**
     * @throws TokenMismatchException
     */
    public function resetPassword(ResetPasswordRequest $request){

        $user = User::where('email', $request->input('email'))->first();

        if(!$user) throw new NotFoundResourceException('user with this email was not found');

        $resetRequest = PasswordReset::where('email', $user->email)->first();

        if(!$resetRequest->validated) throw new TokenMismatchException('Unauthorized request' ,401);

        //Update user's password
        $user->fill([
            'password' => Hash::make($request->input('password'))
        ]);

        $user->save();

        //Delete all previous tokens
        $user->tokens()->delete();

        $resetRequest->delete();

        $token = $user->createToken($request->input('device'))->plainTextToken;

        $data = fractal($user, new LoginTransformer())->addMeta([
            'token'=>$token
        ])->toArray();

        return $this->successResponse($data);
    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return $this->successResponse(null,'User logout successfully');
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
