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
/*
Route::get('/empleado', function () {
    return view('empleado.index');
}); */
//Forma de argumentos (Ruta, [Nombre de la clase, 'metodo de la clase'])

/* Route::get('empleado/create', [EmpleadoController::class,'create']); */

Route::resource('empleado', EmpleadoController::class)->middleware('auth');
Auth::routes();//['register'=>true,'reset'=>true]

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(); */

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

/* Auth::routes(); */

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function (){

    Route::get('/', [EmpleadoController::class, 'index'])->name('home');

});

Route::get('/usuarios', [ControlHorarioController::class, 'getUserInfo']);
Route::post('/usuarios', [ControlHorarioController::class, 'getUserInfoFilter']);