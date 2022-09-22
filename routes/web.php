<?php

use App\Http\Controllers\ControlHorarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
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
    //return view('welcome');
    return view('auth.login');

});

Auth::routes(['register'=>true,'reset'=>true,'verify'=>true]);
Route::group(['middleware'=>['auth','verified']],function (){

    Route::resource('empleado', EmpleadoController::class)->middleware('auth');
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
    Route::get('/home', [EmpleadoController::class, 'index'])->name('home');
    Route::get('/show', [EmpleadoController::class, 'show'])->name('empleado.show');
    Route::get('/usuarios', [ControlHorarioController::class, 'getUserInfo'])->name('usuarios.getuserinfo');
    Route::post('/usuarios', [ControlHorarioController::class, 'getUserInfoFilter']);

});

