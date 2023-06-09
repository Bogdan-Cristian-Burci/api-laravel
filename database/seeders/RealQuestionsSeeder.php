<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Chapter;
use App\Models\Question;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Excel;


class RealQuestionsSeeder extends Seeder
{

    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function run(): void
    {
        $chaptersAdded = [];
        $lastQuestionId=null;

        $collection = (new FastExcel)->import(storage_path('./app/intrebari.xlsx'), function($row) use (&$chaptersAdded,&$lastQuestionId) {

            /**
             * Check if chapter is already added, if not create a new one
             */
            if(!array_key_exists($row["chapter"], $chaptersAdded)){
                $newChapter = Chapter::create([
                    "name"=>$row["chapter"]
                ]);
                $chaptersAdded[$row["chapter"]]=$newChapter->id;
            }

            /**
             * Create a new question if  the field is not empty
             */
            if(!empty($row["Question"])){
                $newQuestion = Question::create([
                    "name"=>"Intrebare",
                    "description"=>$row["Question"],
                    "chapter_id" => $chaptersAdded[$row["chapter"]],
                    "ppi"=>$row["PPI"],
                    "ppc"=>$row["PPC"],
                    "def"=>$row["DEF"],
                ]);

                $lastQuestionId=$newQuestion->id;
            }

            if(!empty($row["Answer"])){
                $newAnswer = Answer::create([
                    "name"=>"Raspuns",
                    "description" => str_replace('*','',$row["Answer"]),
                    "question_id" => $lastQuestionId,
                    'correct' => !empty($row["corect"])
                ]);
            }
        });
    }
}
