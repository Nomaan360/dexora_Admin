<?php

use App\Http\Controllers\adsController;
use App\Http\Controllers\cardsController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\levelsController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\tasksController;
use App\Http\Controllers\comboController;
use App\Http\Controllers\cipherController;
use App\Http\Controllers\winnerController;
use App\Http\Controllers\afilliateTaskController;
use App\Http\Controllers\earnController;
use Illuminate\Http\Request;
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
Route::get('/', function (Request $request) {
    
    $user_id = $request->session()->get('_user_id');
    if (!empty($user_id)) {
        return redirect()->route('dashboard');
    } else {
        return view('login');
    }
})->name('index');

Route::post('/login', [loginController::class, 'login'])->name('login');

Route::any('/logout', [loginController::class, 'logout'])->name('logout');

Route::any('/dashboard', [loginController::class, 'dashboard'])->name('dashboard')->middleware("session");
Route::any('/countSetup', [loginController::class, 'countSetup'])->name('countSetup')->middleware("session");
Route::any('/users', [loginController::class, 'allusers'])->name('allusers')->middleware("session");

Route::any('/weekly-referral-report', [earnController::class, 'index'])->name('reportIndex')->middleware("session");
Route::any('/filter-weekly-referral-report', [earnController::class, 'store'])->name('reportFilter')->middleware("session");
Route::any('/get-affilitate-user', [loginController::class, 'get_affilitate_user'])->name('get_affilitate_user')->middleware("session");

// Route::any('/user-details', [loginController::class, 'userDetails'])->name('userDetails');

    Route::resource('earn', earnController::class);

Route::group(['middleware' => ['session']], function() {
    Route::resource('category', categoryController::class);
    Route::resource('ads', adsController::class);
    Route::resource('tasks', tasksController::class);
    Route::resource('cards', cardsController::class);
    Route::resource('levels', levelsController::class);
    Route::resource('cipher', cipherController::class);
    Route::resource('combo', comboController::class);
    Route::resource('winner', winnerController::class);
    Route::resource('affiliatetask', afilliateTaskController::class);
});
