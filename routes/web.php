<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

/*   For Excel  */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/*   For Email */
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;

/*   For  FPDF  */
use Codedge\Fpdf\Fpdf\Fpdf;



/*   For LDAP */
use Adldap\Laravel\Facades\Adldap;

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


Route::get('error-conexion-db', function() {
    return view('errors.databaseConnectionError');
})->name('error.conexion.db');

Route::get('language/{lang?}', function($lang = 'en') {
    session()->put('language', $lang);
    //return redirect()->back();
    return redirect('/');
})->name('language');

Route::match(['get', 'post'], 'login', [UserController::class, 'login'])->name('login');
Route::group(array('middleware' => array('auth')), function() {
	Route::get('/', [MainController::class, 'index'])->name('index');
	Route::get('logout', [UserController::class, 'logOut'])->name('logout');
	
	Route::get('usuarios', [MainController::class, 'usuarios'])->name('usuarios');
	Route::post('registro_usuarios', [MainController::class, 'registro_usuarios'])->name('registro_usuarios');
	Route::post('buscar_usuario', [MainController::class, 'buscar_usuario'])->name('buscar_usuario');
	Route::post('buscar_correo', [MainController::class, 'buscar_correo'])->name('buscar_correo');
	Route::post('buscar_edicion_user', [MainController::class, 'buscar_edicion_user'])->name('buscar_edicion_user');

	Route::get('personas', [MainController::class, 'personas'])->name('personas');
	Route::post('registro_personas', [MainController::class, 'registro_personas'])->name('registro_personas');
	Route::post('buscar_edicion_persona', [MainController::class, 'buscar_edicion_persona'])->name('buscar_edicion_persona');

	Route::get('visualizacion', [MainController::class, 'visualizacion'])->name('visualizacion');
	Route::post('buscar_cola', [MainController::class, 'buscar_cola'])->name('buscar_cola');
	Route::post('actualiza_status_cola', [MainController::class, 'actualiza_status_cola'])->name('actualiza_status_cola');
	
});






