<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\QuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingType;
use App\Transformers\PaginatorAdapter;
use App\Transformers\Quiz\QuizTransformer;
use Illuminate\Http\JsonResponse;

class QuizController extends ApiController
{

    private const QUIZ_TYPE=[
        "X"=>["C1"=>4,"C2"=>4,"C3"=>4,"C4"=>4,"C5"=>4,"C6"=>4,"C7"=>4,"C8"=>4,"C9"=>4,"C10"=>0,"C11"=>4],
        "CO_CE"=>["C1"=>4,"C2"=>4,"C3"=>4,"C4"=>4,"C5"=>4,"C6"=>4,"C7"=>4,"C8"=>4,"C9"=>4,"C10"=>2,"C11"=>2],
        "CE"=>["C1"=>4,"C2"=>4,"C3"=>4,"C4"=>4,"C5"=>4,"C6"=>4,"C7"=>4,"C8"=>4,"C9"=>4,"C10"=>2,"C11"=>2]
    ];
    /**
     * Get all quizzes
     * @return JsonResponse
     */
    public function index()
    {
        $paginator = Quiz::paginate();
        $quizzes = $paginator->getCollection();
        $data = fractal($quizzes,new QuizTransformer())->paginateWith( new PaginatorAdapter($paginator));

        return $this->successResponse($data,'Collection found with success');
    }

    /**
     * Add new quiz
     * @param QuizRequest $request
     * @return JsonResponse
     */
    public function store(QuizRequest $request)
    {
       $quiz = Quiz::create([
           'name'=>$request->input('name'),
           'user_id' => $request->user()->id,
           'number_of_questions'=>$request->input('name') === 'demo' ? 10 : Quiz::$TOTAL_NUMBER_OF_QUESTIONS,
           'training_id'=>$request->input('training_id'),
       ]);

       $questionIds = $this->allocateQuestionsToQuiz($quiz);

        $quiz->questions()->attach($questionIds);

       $data = fractal($quiz, new QuizTransformer());

       return $this->successResponse($data,'Quiz created with success',201);
    }

    /**
     * Get quiz by id
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function show(Quiz $quiz)
    {

        $data = fractal($quiz, new QuizTransformer());

        return $this->successResponse($data,'Quiz found with success');
    }

    /**
     * Update quiz name - user cannot be updated since quiz in generated random when user starts a new quiz
     * @param UpdateQuizRequest $request
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update([
            'name'=>$request->input('name')
        ]);

        $data = fractal($quiz, new QuizTransformer());

        return $this->successResponse($data,'Quiz updated with success');
    }

    /**
     * Delete quiz by id
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return $this->successResponse(null,'Quiz deleted with success',204);
    }

    private function allocateQuestionsToQuiz(Quiz $quiz):array{

        $chapters = Chapter::all();
        $numberOfQuestions = $quiz->number_of_questions;
        $training = Training::find($quiz->training_id);

        //Get type of quiz that will be generated
        $trainingCategory = $training->category->code;

        //Get question based on category selected
        $trainingType = \Str::lower($training->type->code);

        $quizQuestions = collect();

        if($chapters->count() > 1){

            foreach ($chapters as $chapter){

                $questionsPerChapter = self::QUIZ_TYPE[$trainingCategory][$chapter->name];

                $arrCategory = $this->getCategoriesCodes($trainingCategory);

                $chapterQuestions = $chapter->questions()->whereIn($trainingType,$arrCategory)->inRandomOrder()->limit($questionsPerChapter)->get();
                $quizQuestions = $quizQuestions->merge($chapterQuestions);

                //If the number of questions in this chapter is less than the target number, get the difference from other chapters
                if($chapterQuestions->count() < $questionsPerChapter){
                    $remainingQuestions = $questionsPerChapter - $chapter->questions()->count();
                    $remainingChapterQuestions = $chapter->questions()->skip($questionsPerChapter)->limit($remainingQuestions)->get();
                    $quizQuestions=$quizQuestions->merge($remainingChapterQuestions);
                }
                // If we've selected enough questions, exit the loop
                if ($quizQuestions->count() >= $numberOfQuestions) {
                    break;
                }

            }

        }else{
            $quizQuestions = Question::take($numberOfQuestions)->get();
        }

        return $quizQuestions->pluck('id')->toArray();

    }

    public function getLastQuizData(){

        $user = request()->user();

        $lastQuiz = $user->lastQuiz;
        $responses = $lastQuiz->responses;

        $correctAnswers = $responses->where('is_correct',true)->count();
        $inCorrectAnswers = $responses->where('is_correct',false)->count();

        $totalQuestions = $lastQuiz->number_of_questions;

        $data = [
            "total"=>$totalQuestions,
            "correct"=>$correctAnswers,
            "incorrect"=>$inCorrectAnswers,
            "unanswered"=>$totalQuestions - ($correctAnswers+$inCorrectAnswers)
        ];

        return $this->successResponse($data,'Summary calculated');
    }

    public function getCategoriesCodes($trainingCategory) : array{

        if($trainingCategory === 'X') return ['X'];

        if($trainingCategory === 'CO CE') return ['X','CO CE'];

        if($trainingCategory === 'CE') return ['X','CO CE','CE'];

        return [];
    }

}
