<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('/test',function(){
//     return "'hello jewt'";
// });
Route::middleware('jwt')->group(function () {
    Route::get('/test',function(){
        return "'hello jewt'";
    });
   
});


Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);