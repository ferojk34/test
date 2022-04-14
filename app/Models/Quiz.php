<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        "question",
        "answer",
    ];

    const RESULT_GOOD = "Good";
    const RESULT_FAIR = "Fair";
    const RESULT_NEUTRAL = "Neutral";
    const RESULT_BAD = "Bad";

    public static $result_flags = [
        self::RESULT_GOOD,
        self::RESULT_FAIR,
        self::RESULT_NEUTRAL,
        self::RESULT_BAD,
    ];
}
