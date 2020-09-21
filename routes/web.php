<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\ProjectTaskController;
 Route::get('/', function () {
    return view('welcome');
});
 Route::group(['middleware'=>'auth'],function (){
     Route::resource('projects',ProjectController::class);
     Route::post('projects/{project}/task',[ProjectTaskController::class,'store']);
     Route::patch('projects/{project}/task/{task}',[ProjectTaskController::class,'update']);
 });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
