<?php

use App\Exports\ExampleExport;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TransformationController;
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
    return view('welcome');
});

Route::prefix('cms/admin')->middleware('guest:admin')->group(function(){
    Route::get('/login' , [AuthController::class , 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('cms/admin')->middleware('auth:admin')->group(function() {
    Route::view('/', 'cms.parent');
    Route::get('transformation', [TransformationController::class , 'transformation'])->name('transformation');
    Route::post('transfer', [TransformationController::class , 'transfer']);
    Route::get('index', [TransformationController::class , 'index'])->name('index');
    Route::resource('admins', AdminsController::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/export', [ExportController::class , 'export'])->name('export');
});
