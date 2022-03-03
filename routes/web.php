<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index']);
Route::get('/home',[HomeController::class,'redirect'])->middleware('auth','verified');
Route::get('/add_doctor',[AdminController::class,'addview']);
Route::post('/uploaddoctor',[AdminController::class,'upload']);
Route::post('/uploadappointment',[HomeController::class,'uploadappointment']);
Route::get('/myappointment',[HomeController::class,'showappoint']);
Route::get('/cancelappoint/{id}',[HomeController::class,'cancelappoint']);
Route::get('/showappointment',[AdminController::class,'showappointment']);
Route::get('/approved/{id}',[AdminController::class,'approved']);
Route::get('/canceled/{id}',[AdminController::class,'canceled']);
Route::get('/showdoctor',[AdminController::class,'showdoctor']);
Route::get('/delete/{id}',[AdminController::class,'delete']);
Route::get('/updatedoctor/{id}',[AdminController::class,'updatedoctor']);
Route::post('/update/{id}',[AdminController::class,'update']);
Route::get('/emailview/{id}',[AdminController::class,'emailview']);
Route::post('/sendmail/{id}',[AdminController::class,'sendmail']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
