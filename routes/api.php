<?php

use App\Http\Controllers\API\CategoryRouteController;
use App\Http\Controllers\API\ContactRouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductRouteController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//TODO product apis
Route::prefix('product')->group(function () {

    //get
    Route::prefix('get')->group(function () {
        Route::get('list', [ProductRouteController::class, 'getList']);
    });
});

//TODO category apis
Route::prefix('category')->group(function () {

    //get
    Route::prefix('get')->group(function () {
        Route::get('list', [CategoryRouteController::class, 'getList']);
    }); //get end

    //post
    Route::prefix('post')->group(function () {
        Route::post('create', [CategoryRouteController::class, 'postCreate']);
        Route::post('delete',[CategoryRouteController::class, 'postDelete']);
        Route::post('details', [CategoryRouteController::class, 'postDetails']);
        Route::post('update', [CategoryRouteController::class, 'postUpdate']);
    });
});


//TODO contact apis
Route::prefix('contact')->group(function () {




    //Post
    Route::prefix('post')->group(function() {
        Route::post('create', [ContactRouteController::class, 'postCreate']);
    });
});

