<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
//     return $request->user();
// });

Route::get("/", fn () => response()->json(['message' => '༼ つ ◕_◕ ༽つ']));

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/account', [AuthController::class, 'getAccountInfo'])->name('auth.account');

Route::group(['middleware' => 'access_token'], function () {
    Route::match(['get', 'post'], '/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::match(['get', 'post'], '/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
});
