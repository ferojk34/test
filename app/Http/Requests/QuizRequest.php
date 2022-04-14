<?php

namespace App\Http\Requests;

use App\Models\Quiz;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "question" => "required",
            "answer" => ["required", Rule::in(Quiz::$result_flags)],
        ];
    }

    public function messages(): array
    {
        return [
            "question.required" => "question is required",
            "answer.required" => "answer is required",
        ];
    }
}
