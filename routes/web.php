<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\PantallaController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\Api\ApiController;

// ── Kiosco (público) ─────────────────────────────────────────────────────────
Route::get('/', [TurnoController::class, 'index'])->name('kiosco.index');
Route::get('/kiosco', [TurnoController::class, 'index']);
Route::get('/solicitar', [TurnoController::class, 'index']);
Route::post('/turno/solicitar', [TurnoController::class, 'store'])
    ->name('turnos.store')
    ->middleware('throttle:kiosk');
Route::get('/turno/tiquete/{tur_numero}', [TurnoController::class, 'tiquete'])->name('turno.tiquete');
Route::post('/turno/consultar', [TurnoController::class, 'consultarTurno'])->name('turno.consultar');

// ── Pantalla (público) ───────────────────────────────────────────────────────
Route::get('/pantalla', [PantallaController::class, 'index'])->name('pantalla.index');
Route::get('/api/pantalla/data', [ApiController::class, 'getPantallaData'])->name('pantalla.api.data');
Route::get('/api/pantalla/ultimo-turno', [ApiController::class, 'getUltimoTurno'])->name('pantalla.api.ultimo-turno');

// ── Asesor Auth ──────────────────────────────────────────────────────────────
Route::get('/asesor/login', [AsesorController::class, 'showLogin'])->name('asesor.login');
Route::post('/asesor/login', [AsesorController::class, 'login']);
Route::post('/asesor/logout', [AsesorController::class, 'logout'])->name('asesor.logout');
Route::get('/asesor/recuperar-clave', fn() => view('asesor.recuperar_clave'))->name('asesor.recuperar');

// ── Asesor (requiere sesión) ─────────────────────────────────────────────────
Route::middleware('auth.asesor')->group(function () {
    Route::get('/asesor',                [AsesorController::class, 'index'])->name('asesor.index');
    Route::get('/asesor/actividad',      [AsesorController::class, 'actividad'])->name('asesor.actividad');
    Route::get('/asesor/tramites',       [AsesorController::class, 'tramites'])->name('asesor.tramites');
    Route::get('/asesor/reportes',       [AsesorController::class, 'reportes'])->name('asesor.reportes');
    Route::get('/asesor/configuracion',  [AsesorController::class, 'configuracion'])->name('asesor.configuracion');
    Route::get('/manual/asesor',         [AsesorController::class, 'manualAsesor'])->name('manual.asesor');

    Route::post('/asesor/llamar',                    [AsesorController::class, 'llamar'])->name('asesor.llamar');
    Route::post('/asesor/finalizar/{atnc_id}',       [AsesorController::class, 'finalizar'])->name('asesor.finalizar');
    Route::post('/asesor/ausente/{atnc_id}',         [AsesorController::class, 'ausente'])->name('asesor.ausente');
    Route::post('/asesor/persona/update/{pers_doc}', [AsesorController::class, 'updatePersona'])->name('asesor.persona.update');

    // CU-03: Receso del Asesor
    Route::post('/asesor/receso/iniciar',   [AsesorController::class, 'registrarReceso'])->name('asesor.receso.iniciar');
    Route::post('/asesor/receso/finalizar', [AsesorController::class, 'finalizarReceso'])->name('asesor.receso.finalizar');
});

// ── Coordinador Auth ─────────────────────────────────────────────────────────
Route::get('/coordinador/login',  [CoordinadorController::class, 'showLogin'])->name('coordinador.login');
Route::post('/coordinador/login', [CoordinadorController::class, 'login']);
Route::post('/coordinador/logout',[CoordinadorController::class, 'logout'])->name('coordinador.logout');

// ── Coordinador (requiere sesión) ────────────────────────────────────────────
Route::middleware('auth.coordinador')->group(function () {
    Route::get('/coordinador',             [CoordinadorController::class, 'index'])->name('coordinador.index');
    Route::get('/dashboard-coordinador',   [CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');
    Route::get('/coordinador/export',      [CoordinadorController::class, 'export'])->name('coordinador.export');
    Route::get('/coordinador/reportes',    [CoordinadorController::class, 'reportes'])->name('coordinador.reportes');
    Route::get('/coordinador/modulos',     [CoordinadorController::class, 'modulos'])->name('coordinador.modulos');
    Route::get('/coordinador/configuracion',[CoordinadorController::class, 'configuracion'])->name('coordinador.configuracion');
    Route::post('/coordinador/configuracion/ciclo', [CoordinadorController::class, 'actualizarCicloTurno'])->name('coordinador.ciclo.update');
    Route::get('/coordinador/supervision', [CoordinadorController::class, 'supervision'])->name('coordinador.supervision');
    Route::get('/manual/coordinador',      [CoordinadorController::class, 'manualCoordinador'])->name('manual.coordinador');

    Route::post('/coordinador/modulos/store',        [CoordinadorController::class, 'storeAsesor'])->name('coordinador.asesores.store');
    Route::post('/coordinador/modulos/update/{id}',  [CoordinadorController::class, 'updateAsesor'])->name('coordinador.asesores.update');
    Route::post('/coordinador/modulos/delete/{id}',  [CoordinadorController::class, 'deleteAsesor'])->name('coordinador.asesores.delete');

    // API para el dashboard del coordinador
    Route::get('/api/coordinador/stats',         [ApiController::class, 'getCoordinatorStats'])->name('coordinador.api.stats');
    Route::get('/api/coordinador/turnos-vencidos',[ApiController::class, 'getTurnosVencidos'])->name('coordinador.api.vencidos');
});

