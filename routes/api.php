<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\TrainingCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum','verified'])->group(function () {

    Route::group(['middleware' => ['role:super-admin']], function () {

        Route::resource('chapters', ChapterController::class,[
            'except'=>['edit','create']
        ]);
        Route::resource('questions', QuestionController::class,[
            'except'=>['edit','create']
        ]);
        Route::post('questions/attach/{question}',[QuestionController::class,'attachQuestionToChapter']);
        Route::post('questions/detach/{question}',[QuestionController::class,'detachQuestionFromChapter']);

        Route::resource('answers', AnswerController::class,[
            'except'=>['index','edit','create']
        ]);
        Route::post('answers/attach/{answer}',[AnswerController::class,'attachAnswerToQuestion']);
        Route::post('answers/detach/{answer}',[AnswerController::class,'detachAnswerFromQuestion']);
    });

    Route::resource('quizzes',QuizController::class,[
        'except'=>['edit','create']
    ]);

    Route::get('last-quiz',[QuizController::class,'getLastQuizData']);
    Route::post('user/update',[UserController::class,'update']);
    Route::get('user/summary',[UserController::class,'getSummary']);
    Route::get('user/user-data',[UserController::class,'getUser']);
    Route::get('user/all-trainings',[UserController::class,'getTrainings']);
    Route::resource('responses', ResponsesController::class,[
        'only'=>['store']
    ]);

    Route::resource('training-category', TrainingCategoryController::class,[
        'only'=>['index']
    ]);

    Route::post('payment/form',[PaymentController::class,'getPaymentForm']);

    Route::post('contact-us',[MailController::class,'contactUs']);

    Route::get('cities/counties',[CityController::class,'getCounties']);
    Route::get('cities/city/{city}',[CityController::class,'getCities']);
});
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('forgot-password', [AuthController::class,'forgotPassword']);
Route::post('reset-password', [AuthController::class,'resetPassword']);
Route::post('validate-token', [AuthController::class,'validateToken']);
Route::post('payment/return',[PaymentController::class,'instantPaymentNotification']);
Route::get('payment/success',[PaymentController::class,'paymentSuccess']);
Route::get('/email/verify/success',[AuthController::class,'emailSuccess']);
Route::get('/email/verify/{id}/{hash}',[AuthController::class,'verifyEmail'])->name('verification.verify');
Route::get('/email/verify/already-success',[AuthController::class,'alreadyChecked']);

Route::post('/test/smart-bill',[PaymentController::class,'sendDataToSmartBill']);
