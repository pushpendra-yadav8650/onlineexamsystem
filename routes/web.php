<?php

use App\Http\Controllers\mailcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register',[AuthController::class,'loadRegister']);
Route::post('/register',[AuthController::class,'StudentRegister'])->name('StudentRegister');
Route::get('/login',function(){
    return redirect('/');
});
Route::get('/',[AuthController::class,'loadlogin']);
Route::post('/login',[AuthController::class,'userlogin'])->name('userlogin');

Route::get('/logout',[AuthController::class,'logout']);

Route::get('/reset-password',[AuthController::class,'resetpasswordLoad']);
Route::post('/reset-password',[AuthController::class,'resetpassword'])->name('resetpassword');

Route::get('/forget-password',[AuthController::class,'forgetpasswordLoad']);
Route::post('/forget-password',[AuthController::class,'forgetpassword'])->name('forgetpassword');
 
 
Route::group(['middleware'=>['web','checkadmin']],function(){
    Route::get('/admin/dashboard',[AuthController::class,'adminDashboard']);

    //Subject route

    Route::post('/add-subject',[AdminController::class,'addSubject'])->name('addSubject');
    //Edit subject 
    Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('editSubject');
    //delete subject
    Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('deleteSubject');

    //Exam route
     Route::get('/admin/exam',[AdminController::class,'examDashboard']);
     Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');

     Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
     Route::POST('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');
     Route::POST('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');

     //Qustion and Answer Routes
     Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
     Route::POST('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');


});

Route::group(['middleware'=>['web','checkstudent']],function(){
    Route::get('/dashboard',[AuthController::class,'loadDashboard']); 


});




