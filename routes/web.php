<?php

use App\Http\Controllers\LoginControlador;
use App\Http\Controllers\DocenteControlador;
use App\Http\Controllers\PeriodoControlador;
use App\Http\Controllers\LugarControlador;
use App\Http\Controllers\ActividadControlador;
use App\Http\Controllers\FechaControlador;
use App\Http\Controllers\RecursoControlador;
use App\Http\Controllers\ListadoFechas;
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


//Docente

Route::get('/',[DocenteControlador::class, 'menu'])->name('menu');

//Route::get('/menu',[DocenteControlador::class, 'menu'])->name('menu');

Route::get('/docente/listarSemana',[DocenteControlador::class, 'listarHorariosSemanal'])->name('listarHorariosSemanal');

Route::get('/docente/importarExcel',[DocenteControlador::class, 'importarExcel'])->name('importarExcel');

Route::post('/docente/importarExcel/crear',[DocenteControlador::class, 'importarExcelActividad'])->name('importarExcelActividad');

Route::get('/docente/nuevo', [DocenteControlador::class,'registraDocente'])->name('registraDocente');

Route::post('/docente/nuevo', [DocenteControlador::class,'nuevoUsuario'])->name('nuevoUsuario');

Route::get('/docente/{codigo}', [DocenteControlador::class,'confirmaUsuario',])->name('confirmaUsuario');

//Recuperacion

Route::post('/recuperaContrasena', [DocenteControlador::class,'recuperaContrasena',])->name('recuperaContrasena');

Route::get('/password/{codigo}', [DocenteControlador::class,'restauraContrasena',])->name('restauraContrasena');

Route::post('/password/{codigo}', [DocenteControlador::class,'cambiaNuevaContrasena',])->name('cambiaNuevaContrasena');

Route::get('/cambiaContrasena', [DocenteControlador::class,'passwordDocente',])->name('passwordDocente');

Route::post('/cambiaContrasena', [DocenteControlador::class,'editaPasswordDocente',])->name('editaPasswordDocente');

Route::get('/docente', [DocenteControlador::class,'docente',])->name('docente');

Route::post('/docente', [DocenteControlador::class,'editaDocente',])->name('editaDocente');

//Login

Route::get('/cerrarsesion',[LoginControlador::class, 'cerrarSesion'])->name('cerrarSesion');

Route::get('/login',[LoginControlador::class, 'login'])->name('login');

Route::post('/login',[LoginControlador::class, 'acceso'])->name('login');




//Periodo

Route::get('/periodo',[PeriodoControlador::class, 'periodo'])->name('periodo');

Route::get('/periodo/crear',[PeriodoControlador::class, 'crearPeriodo'])->name('crearPeriodo');

Route::post('/periodo/validar',[PeriodoControlador::class, 'validaPeriodo'])->name('validaPeriodo');

Route::post('/periodo/crear',[PeriodoControlador::class, 'agregarPeriodo'])->name('agregarPeriodo');

Route::get('/periodo/editar/{periodo}',[PeriodoControlador::class, 'editarPeriodo'])->name('editarPeriodo');

Route::put('/periodo/editar/{periodo}',[PeriodoControlador::class, 'updatePeriodo'])->name('updatePeriodo');

Route::delete('/periodo/eliminar/{periodo}',[PeriodoControlador::class, 'eliminarPeriodo'])->name('eliminarPeriodo');


//Lugares

Route::get('/lugar',[LugarControlador::class, 'lugar'])->name('lugar');

Route::get('/lugar/crear',[LugarControlador::class, 'crearLugar'])->name('crearLugar');

Route::post('/lugar/validar',[LugarControlador::class, 'validaLugar'])->name('validaLugar');

Route::post('/lugar/crear',[LugarControlador::class, 'agregarLugar'])->name('agregarLugar');

Route::get('/lugar/editar/{lugar}',[LugarControlador::class, 'editarLugar'])->name('editarLugar');

Route::put('/lugar/editar/{lugar}',[LugarControlador::class, 'updateLugar'])->name('updateLugar');

Route::delete('/lugar/eliminar/{lugar}',[LugarControlador::class, 'eliminarLugar'])->name('eliminarLugar');

//Actividad

Route::get('/actividad',[ActividadControlador::class, 'actividad'])->name('actividad');

Route::get('/actividad/crear',[ActividadControlador::class, 'crearActividad'])->name('crearActividad');

Route::post('/actividad/validar',[ActividadControlador::class, 'validaActividad'])->name('validaActividad');

Route::post('/actividad/crear',[ActividadControlador::class, 'agregarActividad'])->name('agregarActividad');

Route::get('/actividad/editar/{actividad}',[ActividadControlador::class, 'editarActividad'])->name('editarActividad');

Route::put('/actividad/editar/{actividad}',[ActividadControlador::class, 'updateActividad'])->name('updateActividad');

Route::delete('/actividad/eliminar/{lugar}',[ActividadControlador::class, 'eliminarActividad'])->name('eliminarActividad');

//Fechas (horarios)

Route::get('/fecha',[FechaControlador::class, 'fecha'])->name('fecha');

Route::get('/fecha/crear',[FechaControlador::class, 'crearFecha'])->name('crearFecha');

Route::post('/fecha/validar',[FechaControlador::class, 'validaFecha'])->name('validaFecha');

Route::post('/fecha/crear',[FechaControlador::class, 'agregarFecha'])->name('agregarFecha');

Route::get('/fecha/editar/{fecha}',[FechaControlador::class, 'editarFecha'])->name('editarFecha');

Route::put('/fecha/editar/{fecha}',[FechaControlador::class, 'updateFecha'])->name('updateFecha');

Route::delete('/fecha/eliminar/{fecha}',[FechaControlador::class, 'eliminarFecha'])->name('eliminarFecha');


//Recursos de actividades

Route::get('/recurso',[RecursoControlador::class, 'recurso'])->name('recurso');

Route::get('/recurso/crear',[RecursoControlador::class, 'crearRecurso'])->name('crearRecurso');

Route::post('/recurso/validar',[RecursoControlador::class, 'validaRecurso'])->name('validaRecurso');

Route::post('/recurso/crear',[RecursoControlador::class, 'agregarRecurso'])->name('agregarRecurso');

Route::get('/recurso/editar/{fecha}',[RecursoControlador::class, 'editarRecurso'])->name('editarRecurso');

Route::put('/recurso/editar/{fecha}',[RecursoControlador::class, 'updateRecurso'])->name('updateRecurso');

Route::delete('/recurso/eliminar/{fecha}',[RecursoControlador::class, 'eliminarRecurso'])->name('eliminarRecurso');

//Listado Fecha

Route::post('/listadofecha/validar',[ListadoFechas::class, 'validaListadoFecha'])->name('validaListadoFecha');

Route::post('/listadofecha/editar',[FechaControlador::class, 'editarListadoFecha'])->name('editarListadoFecha');
