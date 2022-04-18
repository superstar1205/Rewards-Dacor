<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::post('/home', [UserController::class, 'home'])->name('home');
Route::post('/getproduts', [UserController::class, 'getproduts'])->name('getproduts');
Route::post('/getdetailinv', [UserController::class, 'getdetailinv'])->name('getdetailinv');

Route::post('/addproduct', [UserController::class, 'addproduct'])->name('addproduct');
Route::post('/sendinvoice', [UserController::class, 'sendinvoice'])->name('sendinvoice');

Route::post('/sendtemail', [UserController::class, 'sendtemail'])->name('sendtemail');

Route::post('/changelang', [UserController::class, 'changelang'] )->name('changelang');

