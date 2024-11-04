<?php

use App\Http\Controllers\Comments\CommentPostController;
use App\Http\Controllers\Comments\CommentVideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('/{user_id}')->whereNumber('user_id')->group(function () {
    Route::resource('/comments_video', CommentVideoController::class)->except(['edit', 'create'])->whereNumber('comments_video');
    Route::resource('/comments_post', CommentPostController::class)->except(['edit', 'create'])->whereNumber('comments_post');
});
