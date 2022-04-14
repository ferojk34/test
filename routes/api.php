<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::resource('quiz', QuizController::class);
