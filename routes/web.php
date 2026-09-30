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

    // ── Number Bundling ──────────────────────────────────────
    Route::prefix('number-bundling')->name('number-bundling.')->group(function () {
        Route::get('/', [\App\Http\Controllers\NumberBundlingController::class, 'index'])->name('index');
        Route::get('/create/{cutOrder}', [\App\Http\Controllers\NumberBundlingController::class, 'create'])->name('create');
        Route::post('/{cutOrder}', [\App\Http\Controllers\NumberBundlingController::class, 'store'])->name('store');
        Route::get('/print-qr/{cutOrder}', [\App\Http\Controllers\NumberBundlingController::class, 'printQr'])->name('print-qr');
    });

    // ── Sewing ──────────────────────────────────────
    Route::prefix('sewing')->name('sewing.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SewingController::class, 'index'])->name('index');
        Route::get('/scan', [\App\Http\Controllers\SewingController::class, 'scan'])->name('scan');
        Route::post('/scan', [\App\Http\Controllers\SewingController::class, 'processScan'])->name('process-scan');
        Route::post('/store/{bundle}', [\App\Http\Controllers\SewingController::class, 'store'])->name('store');
    });

    // ── Panel Inspection ──────────────────────────────────────
    Route::prefix('panel-inspection')->name('panel-inspection.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PanelInspectionController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\PanelInspectionController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\PanelInspectionController::class, 'store'])->name('store');
    });

    // ── Packing ──────────────────────────────────────
    Route::prefix('packing')->name('packing.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PackingController::class, 'index'])->name('index');
        Route::get('/scan', [\App\Http\Controllers\PackingController::class, 'scan'])->name('scan');
        Route::post('/', [\App\Http\Controllers\PackingController::class, 'store'])->name('store');
        Route::get('/print-qr/{packing}', [\App\Http\Controllers\PackingController::class, 'printQr'])->name('print-qr');
    });

    // ── Super Market ──────────────────────────────────────
    Route::prefix('supermarket')->name('supermarket.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SuperMarketController::class, 'index'])->name('index');
        Route::get('/scan-in', [\App\Http\Controllers\SuperMarketController::class, 'scanIn'])->name('scan-in');
        Route::post('/scan-in', [\App\Http\Controllers\SuperMarketController::class, 'storeIn'])->name('store-in');
        Route::get('/scan-out', [\App\Http\Controllers\SuperMarketController::class, 'scanOut'])->name('scan-out');
        Route::post('/scan-out', [\App\Http\Controllers\SuperMarketController::class, 'storeOut'])->name('store-out');
    });

    // ── Spotwash ──────────────────────────────────────
    Route::prefix('spotwash')->name('spotwash.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SpotwashController::class, 'index'])->name('index');
        Route::get('/send', [\App\Http\Controllers\SpotwashController::class, 'send'])->name('send');
        Route::post('/', [\App\Http\Controllers\SpotwashController::class, 'store'])->name('store');
        Route::post('/{spotwash}/cleaned', [\App\Http\Controllers\SpotwashController::class, 'markCleaned'])->name('cleaned');
    });

    // ── Administration ─────────────────────────
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('buyers', \App\Http\Controllers\BuyerController::class);
    Route::resource('bom', \App\Http\Controllers\BomController::class);

    // ── Legacy prototype aliases ───────────────────
    Route::redirect('/fabric-master', '/fabrics')->name('fabric-master.index');
    Route::redirect('/fabric-master/detail', '/fabrics')->name('fabric-master.show');
    Route::redirect('/fabric-groups-manager', '/fabric-groups')->name('fabric-groups-manager.index');
    Route::redirect('/fabric-groups-manager/detail', '/fabric-groups')->name('fabric-groups-manager.show');

    // ── Suppliers & Mills ───────────────────────
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

    // ── Roll Inventory ─────────────────────────
    Route::resource('roll-inventory', \App\Http\Controllers\RollInventoryController::class);

    // ── Fabric Inspection ───────────────────────
    Route::resource('fabric-inspection', \App\Http\Controllers\FabricInspectionController::class);

    // ── Sewing / In-line QC ─────────────────────
    Route::resource('sewing-qc', \App\Http\Controllers\SewingQcController::class);

    // ── Finishing ──────────────────────────────
    Route::resource('finishing-ui', \App\Http\Controllers\FinishingController::class);

    // ── Final Inspection (AQL) ──────────────────
    Route::resource('final-qc', \App\Http\Controllers\FinalQcController::class);

    // ── Carton & Dispatch ───────────────────────
    Route::resource('dispatch-ui', \App\Http\Controllers\DispatchController::class);

    // ── Stock Movement & Traceability ───────────
    Route::resource('traceability', \App\Http\Controllers\TraceabilityController::class);
});



