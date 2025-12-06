<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::any('/user-details', [loginController::class, 'userDetails'])->name('userDetails');
Route::any('/coin-update', [loginController::class, 'coinUpdate'])->name('coinUpdate');
Route::any('/pph-update', [loginController::class, 'pphUpdate'])->name('pphUpdate');
Route::any('/fetch-friends', [loginController::class, 'fetchFriends'])->name('fetchFriends');
Route::any('/fetch-tasks', [loginController::class, 'fetchTasks'])->name('fetchTasks');

Route::any('/insert-earn-log', [loginController::class, 'insertEarnLog'])->name('insertEarnLog');
Route::any('/insert-affilitate-join', [loginController::class, 'insertAffiliatejoin'])->name('insertAffiliatejoin');
Route::any('/check-affilitate-join', [loginController::class, 'checkAffiliatejoin'])->name('checkAffiliatejoin');
Route::any('/mine-card', [loginController::class, 'mineCard'])->name('mineCard');


Route::any('/check-in-reward', [loginController::class, 'checkInReward'])->name('checkInReward');
Route::any('/get-cipher', [loginController::class, 'getCipher'])->name('getCipher');
Route::any('/get-combo', [loginController::class, 'getCombo'])->name('getCombo');
Route::any('/daily-tasks', [loginController::class, 'dailyTasks'])->name('dailyTasks');
Route::any('/clan-leadership', [loginController::class, 'clanLeadership'])->name('clanLeadership');
Route::any('/get-winners', [loginController::class, 'getWinners'])->name('getWinners');
Route::any('/update-winner-details', [loginController::class, 'updateWinnerDetails'])->name('updateWinnerDetails');
Route::any('/update_cipher', [loginController::class, 'update_cipher'])->name('update_cipher');

Route::any('/do-referral', [loginController::class, 'doReferral'])->name('doReferral');
Route::any('/store-exchange', [loginController::class, 'store_exchange'])->name('store_exchange');
Route::any('/get-exchange', [loginController::class, 'get_exchange'])->name('get_exchange');
Route::any('/fetch-affiliate-task', [loginController::class, 'fetch_affiliate_task'])->name('fetch_affiliate_task');
