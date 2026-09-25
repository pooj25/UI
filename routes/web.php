<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\FabricGroupController;
use App\Http\Controllers\GrnController;
use App\Http\Controllers\LayModelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login or dashboard
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

// Authentication routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fabric Master
    Route::resource('fabrics', FabricController::class);

    // Fabric Groups
    Route::resource('fabric-groups', FabricGroupController::class);
    Route::post('/fabric-groups/{fabricGroup}/add-fabric', [FabricGroupController::class, 'addFabric'])
         ->name('fabric-groups.add-fabric');
    Route::delete('/fabric-groups/{fabricGroup}/remove-fabric/{fabric}', [FabricGroupController::class, 'removeFabric'])
         ->name('fabric-groups.remove-fabric');

    // Lay Models
    Route::resource('lay-models', LayModelController::class);

    // AJAX: Get fabrics for a specific fabric group
    Route::get('/api/fabrics-by-group', [LayModelController::class, 'getFabricsByGroup'])
         ->name('api.fabrics-by-group');

    // ── GRN (Goods Receipt Note) ──────────────────────────────────────
    Route::resource('grn', GrnController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/grn/{grn}/print-labels',      [GrnController::class, 'printLabels'])->name('grn.print-labels');
    Route::get('/grn/roll/{roll}/print-label', [GrnController::class, 'printSingleLabel'])->name('grn.print-single-label');
    Route::get('/grn/roll/{roll}/inspect',     [GrnController::class, 'inspectRoll'])->name('grn.inspect-roll');
    Route::post('/grn/roll/{roll}/inspect',    [GrnController::class, 'storeInspection'])->name('grn.store-inspection');
    Route::get('/grn-scan',                    [GrnController::class, 'scanQr'])->name('grn.scan');

    // ── Fabric Reserve ──────────────────────────────────────
    Route::resource('fabric-reserve', \App\Http\Controllers\FabricReserveController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/fabric-reserve/{fabricReserve}/approve', [\App\Http\Controllers\FabricReserveController::class, 'approve'])->name('fabric-reserve.approve');
    Route::post('/fabric-reserve/{fabricReserve}/issue', [\App\Http\Controllers\FabricReserveController::class, 'issue'])->name('fabric-reserve.issue');
    Route::post('/fabric-reserve/{fabricReserve}/cancel', [\App\Http\Controllers\FabricReserveController::class, 'cancel'])->name('fabric-reserve.cancel');

    // ── Cutman (Cutting Order) ──────────────────────────────────────
    Route::resource('cutman', \App\Http\Controllers\CutmanController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/cutman/{cutman}/start', [\App\Http\Controllers\CutmanController::class, 'start'])->name('cutman.start');
    Route::post('/cutman/{cutman}/complete', [\App\Http\Controllers\CutmanController::class, 'complete'])->name('cutman.complete');
    Route::post('/cutman/{cutman}/roll/{roll}', [\App\Http\Controllers\CutmanController::class, 'updateRollUsage'])->name('cutman.roll.usage');
});
