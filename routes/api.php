<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\DepartmentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

Route::post('/create-departments',[DepartmentsController::class,'storedepartments']);
Route::get('/get-departments',[DepartmentsController::class,'fetchdepartments']);
Route::get('/view-departments-by-id/{id}',[DepartmentsController::class,'viewdepartments']);
Route::put('/update-departments/{id}',[DepartmentsController::class,'update']);
Route::delete('/delete-departments/{id}',[DepartmentsController::class,'destroy']);

});