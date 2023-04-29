<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\QuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Quiz;
use App\Transformers\PaginatorAdapter;
use App\Transformers\QuizTransformer;
use Illuminate\Http\JsonResponse;

class QuizController extends ApiController
{
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
           'user_id' => $request->input('user_id'),
           'number_of_questions'=>$request->input('number_of_questions') ?? Quiz::$TOTAL_NUMBER_OF_QUESTIONS
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

        $quizQuestions = collect();

        if($chapters->count() > 1){

            $questionsPerChapter = floor($numberOfQuestions / $chapters->count());

            foreach ($chapters as $chapter){

                $chapterQuestions = $chapter->questions()->take($questionsPerChapter)->get();
                $quizQuestions = $quizQuestions->merge($chapterQuestions);

                //If the number of questions in this chapter is less than the target number, get the difference from other chapters
                if($chapterQuestions->count() < $questionsPerChapter){
                    $remainingQuestions = $questionsPerChapter - $chapter->questions()->count();
                    $remainingChapterQuestions = $chapter->questions()->skip($questionsPerChapter)->take($remainingQuestions)->get();
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
}
