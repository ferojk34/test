<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Quiz;
use App\Http\Requests\QuizRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    protected $quiz;

    public function __construct()
    {
        $this->quiz = new Quiz();
    }

    public function index()
    {
        try
        {
            $quizes = $this->quiz->get();
            $result = [];
            $quizes->map(callback: function ($data) use (&$result) {
                return array_key_exists($data->answer, $result)
                ? $result[$data->answer]++
                : $result[$data->answer] = 1;
            });
            $data = [];
            $total_quiz = count($quizes);
            foreach ($result as $key => $row) {
                $data[] = [
                    "answer_flag" => $key,
                    "percent" => ($row / $total_quiz) * 100,
                ];
            }
        }
        catch (Exception $exception)
        {
            return response()->json([
                "status" => "error",
                "message" => $exception->getMessage(),
            ], Response:: HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => "success",
            "message" => __("response.fetch-success", ["name" => "quiz result"]),
            "payload" => $data,
            ], Response::HTTP_OK);
    }

    public function store(QuizRequest $request): JsonResponse
    {
        try
        {
            $data =  [
                "question" => $request->question,
                "answer" => $request->answer,
            ];
            $created = $this->quiz->create($data);
        }
        catch (ValidationException $exception)
        {
            return response()->json([
                "status" => "error",
                "message" => json_encode($exception->errors()),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        catch (Exception $exception)
        {
            return response()->json([
                "status" => "error",
                "message" => $exception->getMessage(),
            ], Response:: HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => "success",
            "message" => __("response.submit-success", ["name" => "quiz"]),
            "payload" => $created,
        ], Response::HTTP_CREATED);
    }
}
