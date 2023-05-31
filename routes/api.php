<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResponsesController;
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

Route::middleware('auth:sanctum')->group(function () {

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
    Route::get('user/summary',[UserController::class,'getSummary']);
    Route::get('user/user-data',[UserController::class,'getUser']);
    Route::resource('responses', ResponsesController::class,[
        'only'=>['store']
    ]);
});

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
