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
use App\Notifications\AfterEmailValidationNotification;
use App\Notifications\PasswordResetNotification;
use App\Transformers\User\CreateUserTransformer;
use App\Transformers\User\LoginTransformer;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Hash;
use Log;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AuthController extends ApiController
{
    public const GIRLS_NAMES = ['Agnes', 'Ingrid', 'Carmen', 'Edith', 'Noemi','Beatrice','Erin','Iris','Miriam','Naomi','Noemi','Odette','Zoe'];

    public function register(CreateUserRequest $request)
    {
        $user = User::create([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'password'=>Hash::make($request->input('password')),
            'icon_number' => 2
        ]);

        //check if user first name is a boy or a girl name
        if (preg_match('/a$/', $user->first_name) ||  in_array($user->first_name,self::GIRLS_NAMES)) {
            $user->update([
                'icon_number' => 1
            ]);
        }

        $availableTrainings = Training::all();

        event(new Registered($user));

        foreach ($availableTrainings as $training){

            UserTraining::create([
                'training_id'=>$training->id,
                'user_id'=>$user->id,
                'active'=>false,
                'expire_at'=>null,
            ]);
        }

        $data = fractal($user, new CreateUserTransformer())
            ->toArray();

        return $this->successResponse($data,'User created successfully',201);
    }

    /**
     * @throws AuthenticationException
     */
    public function login(LoginUserRequest $request){


            $user = User::where('email',$request->input('email'))->first();

            if(!$user) throw new NotFoundResourceException('User not found');

            if(Hash::check($request->input('password'), $user->password)){

                $token = $user->createToken($request->input('device'))->plainTextToken;

                $data = fractal($user, new LoginTransformer())->addMeta([
                    'token'=>$token
                ])->toArray();

                return $this->successResponse($data);
            }else{
                throw new AuthenticationException();
            }

        return $this->errorResponse(500,'Something went wrong, try again later');
    }

    /**
     * @throws Exception
     */
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

        if(Carbon::parse($resetRequest->created_at)->addMinutes(config('auth.reset_token_availability'))->isPast()) {
            $resetRequest->delete();
            throw new TokenMismatchException('Token expired', 401);
        }
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

    public function logout(Request $request){
        try{
            $request->user()->tokens()->delete();
            return $this->successResponse(null,'User logout successfully');
        }catch (\Exception $e){
            Log::error('logout exception'.$e->getMessage());
            return $this->errorResponse($e->getCode(), $e->getMessage());
        }
    }
    public function verifyEmail(Request $request){

        $user = User::find($request->route('id'));

        if($user->hasVerifiedEmail()){
            return redirect('/api/email/verify/already-success');
        }

        if($user->markEmailAsVerified()){
           $user->notify(new AfterEmailValidationNotification());
        }

        return redirect('/api/email/verify/success');
    }

    public function emailSuccess(){
        return view('email.verify.success');
    }

    public function alreadyChecked(){
        return view('email.verify.already-success');
    }

    public function deleteAccount(Request $request){
        $request->user()->tokens()->delete();
        $user = $request->user();
        $randomString = Str::random(10);
        $user->email = $randomString.'@'.$randomString.'.com';
        $user->save();
        $user->delete();
        return $this->successResponse(null,'User deleted with success',204);
    }
}
