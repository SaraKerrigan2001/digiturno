<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\PantallaController;
use App\Http\Controllers\CoordinadorController;

// Kiosco
Route::get('/', [TurnoController::class, 'index'])->name('kiosco.index');
Route::get('/solicitar', [TurnoController::class, 'index']);
Route::post('/turno/solicitar', [TurnoController::class, 'store'])->name('turnos.store');

// Pantalla
Route::get('/pantalla', [PantallaController::class, 'index'])->name('pantalla.index');

// Asesor
Route::get('/asesor', [AsesorController::class, 'index'])->name('asesor.index');
Route::get('/asesor/actividad', [AsesorController::class, 'actividad'])->name('asesor.actividad');
Route::get('/asesor/tramites', [AsesorController::class, 'tramites'])->name('asesor.tramites');
Route::get('/asesor/reportes', [AsesorController::class, 'reportes'])->name('asesor.reportes');
Route::get('/asesor/configuracion', [AsesorController::class, 'configuracion'])->name('asesor.configuracion');

// Coordinador
Route::get('/coordinador', [CoordinadorController::class, 'index'])->name('coordinador.index');
Route::get('/dashboard-coordinador', [CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');
Route::get('/coordinador/export', [CoordinadorController::class, 'export'])->name('coordinador.export');
Route::get('/coordinador/reportes', [CoordinadorController::class, 'reportes'])->name('coordinador.reportes');
Route::get('/coordinador/modulos', [CoordinadorController::class, 'modulos'])->name('coordinador.modulos');
Route::get('/coordinador/configuracion', [CoordinadorController::class, 'configuracion'])->name('coordinador.configuracion');
