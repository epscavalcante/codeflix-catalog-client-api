<?php

use App\Http\Controllers\CastMemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)
    ->prefix('categories')
    ->group(function () {
        Route::get('/', 'search')->name('categories.search');
        Route::get('{categoryId}', 'find')->name('categories.find');
    });

Route::controller(CastMemberController::class)
    ->prefix('cast-members')
    ->group(function () {
        Route::get('/', 'search')->name('castMembers.search');
        Route::get('{castMemberId}', 'find')->name('castMembers.find');
    });

Route::controller(GenreController::class)
    ->prefix('genres')
    ->group(function () {
        Route::get('/', 'search')->name('genres.search');
        Route::get('{genreId}', 'find')->name('genres.find');
    });
