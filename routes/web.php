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
Route::get('/', function () {
    return redirect('advisors');
});
/*Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/parrainage', [App\Http\Controllers\DashboardController::class, 'parrainage'])->name('parrainage');
Route::get('/animation', [App\Http\Controllers\DashboardController::class, 'animation'])->name('animation');
Route::get('/chiffres', [App\Http\Controllers\DashboardController::class, 'calculchiffres'])->name('chiffres');*/
Route::get('/passage_grade', [App\Http\Controllers\AdvisorController::class, 'passageGrade'])->name('passageGrade');
Route::get('/calcul_new_rank', [App\Http\Controllers\AdvisorController::class, 'newRank'])->name('calcul.new_rank');
Route::get('/advisors', [App\Http\Controllers\AdvisorController::class, 'index'])->name('advisors');
Route::get('/advisor/{id}', [App\Http\Controllers\AdvisorController::class, 'show'])->name('advisor.show');
