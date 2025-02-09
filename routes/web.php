<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SppdController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\Transaction\IncomingLetterController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Transaction\ExportLetterController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Sppd\ExportSppdController;
use App\Http\Controllers\Spt\ExportSptController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

    Route::resource('user', \App\Http\Controllers\UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    Route::get('profile', [\App\Http\Controllers\PageController::class, 'profile'])
        ->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\PageController::class, 'profileUpdate'])
        ->name('profile.update');
    Route::put('profile/deactivate', [\App\Http\Controllers\PageController::class, 'deactivate'])
        ->name('profile.deactivate')
        ->middleware(['role:staff']);

    Route::get('settings', [\App\Http\Controllers\PageController::class, 'settings'])
        ->name('settings.show')
        ->middleware(['role:admin']);
    Route::put('settings', [\App\Http\Controllers\PageController::class, 'settingsUpdate'])
        ->name('settings.update')
        ->middleware(['role:admin']);

    Route::delete('attachment', [\App\Http\Controllers\PageController::class, 'removeAttachment'])
        ->name('attachment.destroy');

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::prefix('incoming')->name('incoming.')->group(function () {
            Route::get('/', [IncomingLetterController::class, 'index'])->name('index');
            Route::get('/create', [IncomingLetterController::class, 'create'])->name('create');
            Route::post('/', [IncomingLetterController::class, 'store'])->name('store');
            Route::get('/{letter}/edit', [IncomingLetterController::class, 'edit'])->name('edit');
            Route::put('/{letter}', [IncomingLetterController::class, 'update'])->name('update');
            Route::delete('/{letter}', [IncomingLetterController::class, 'destroy'])->name('destroy');
            Route::get('/export', [ExportLetterController::class, 'exportIncoming'])->name('export');
        });
        Route::resource('outgoing', \App\Http\Controllers\OutgoingLetterController::class);
        Route::resource('{letter}/disposition', \App\Http\Controllers\DispositionController::class)->except(['show']);

        // SPPD Routes
        Route::prefix('sppd')->as('sppd.')->group(function () {
            Route::get('domestic', [\App\Http\Controllers\SppdController::class, 'domestic'])->name('domestic');
            Route::get('foreign', [\App\Http\Controllers\SppdController::class, 'foreign'])->name('foreign');
            Route::resource('domestic', \App\Http\Controllers\DomesticSppdController::class)->except(['index']);
            Route::resource('foreign', \App\Http\Controllers\ForeignSppdController::class)->except(['index']);
            Route::get('/foreign/export', [SppdController::class, 'foreignExport'])->name('foreign.export');
            Route::get('/export', [SppdController::class, 'export'])->name('export');
            Route::post('/foreign/store', [SppdController::class, 'foreignStore'])->name('foreign.store');
            Route::get('/domestic/export', [ExportSppdController::class, 'exportDomestic'])
                ->name('sppd.domestic.export');
            Route::get('/foreign/export', [ExportSppdController::class, 'exportForeign'])
                ->name('sppd.foreign.export');
        });

        // SPT Routes
        Route::prefix('spt')->group(function () {
            // Dalam Daerah
            Route::get('/domestic', [SptController::class, 'indexDomestic'])->name('spt.domestic.index');
            Route::post('/domestic', [SptController::class, 'storeDomestic'])->name('spt.domestic.store');
            Route::get('/domestic/{spt}/edit', [SptController::class, 'editDomestic'])->name('spt.domestic.edit');
            Route::put('/domestic/{spt}', [SptController::class, 'updateDomestic'])->name('spt.domestic.update');
            Route::delete('/domestic/{spt}', [SptController::class, 'destroyDomestic'])->name('spt.domestic.destroy');
            Route::get('/domestic/export', [ExportSptController::class, 'exportDomestic'])->name('spt.domestic.export');
            Route::get('/domestic/{spt}/print', [SptController::class, 'printDomestic'])->name('spt.domestic.print');

            // Luar Daerah
            Route::get('/foreign', [SptController::class, 'indexForeign'])->name('spt.foreign.index');
            Route::post('/foreign', [SptController::class, 'storeForeign'])->name('spt.foreign.store');
            Route::get('/foreign/{spt}/edit', [SptController::class, 'editForeign'])->name('spt.foreign.edit');
            Route::put('/foreign/{spt}', [SptController::class, 'updateForeign'])->name('spt.foreign.update');
            Route::delete('/foreign/{spt}', [SptController::class, 'destroyForeign'])->name('spt.foreign.destroy');
            Route::get('/foreign/export', [ExportSptController::class, 'exportForeign'])->name('spt.foreign.export');
            Route::get('/foreign/{spt}/print', [SptController::class, 'printForeign'])->name('spt.foreign.print');
        });

        Route::get('/incoming', [IncomingLetterController::class, 'index'])->name('incoming.index');
    });

    // Archive Routes
    Route::prefix('archive')->as('archive.')->group(function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::resource('document', \App\Http\Controllers\ArchiveDocumentController::class)->except(['index']);
    });

    // Draft PHD Routes
    Route::prefix('draft-phd')->as('draft-phd.')->group(function () {
        Route::get('sk', [\App\Http\Controllers\DraftPhdController::class, 'sk'])->name('sk');
        Route::get('perda', [\App\Http\Controllers\DraftPhdController::class, 'perda'])->name('perda');
        Route::get('pergub', [\App\Http\Controllers\DraftPhdController::class, 'pergub'])->name('pergub');
        
        Route::resource('sk-document', \App\Http\Controllers\SkDocumentController::class)->except(['index']);
        Route::resource('perda-document', \App\Http\Controllers\PerdaDocumentController::class)->except(['index']);
        Route::resource('pergub-document', \App\Http\Controllers\PergubDocumentController::class)->except(['index']);
    });

    Route::prefix('agenda')->as('agenda.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\IncomingLetterController::class, 'agenda'])->name('incoming');
        Route::get('incoming/print', [\App\Http\Controllers\IncomingLetterController::class, 'print'])->name('incoming.print');
        Route::get('outgoing', [\App\Http\Controllers\OutgoingLetterController::class, 'agenda'])->name('outgoing');
        Route::get('outgoing/print', [\App\Http\Controllers\OutgoingLetterController::class, 'print'])->name('outgoing.print');
    });

    Route::prefix('gallery')->as('gallery.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\LetterGalleryController::class, 'incoming'])->name('incoming');
        Route::get('outgoing', [\App\Http\Controllers\LetterGalleryController::class, 'outgoing'])->name('outgoing');
    });

    Route::prefix('reference')->as('reference.')->middleware(['role:admin'])->group(function () {
        Route::resource('classification', \App\Http\Controllers\ClassificationController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', \App\Http\Controllers\LetterStatusController::class)->except(['show', 'create', 'edit']);
    });

    // Route untuk SPPD Luar Daerah
    Route::get('/sppd/foreign', [SppdController::class, 'foreign'])->name('sppd.foreign');
    Route::post('/sppd/foreign/store', [SppdController::class, 'foreignStore'])->name('sppd.foreign.store');
    Route::put('/sppd/foreign/{id}', [SppdController::class, 'foreignUpdate'])->name('sppd.foreign.update');
    Route::delete('/sppd/foreign/{id}', [SppdController::class, 'foreignDestroy'])->name('sppd.foreign.destroy');

    // Route untuk SPPD Dalam Daerah
    Route::prefix('sppd')->name('sppd.')->group(function () {
        Route::get('/domestic', [SppdController::class, 'domestic'])->name('domestic');
        Route::post('/domestic', [SppdController::class, 'store'])->name('domestic.store');
        Route::get('/export', [SppdController::class, 'export'])->name('export');
        Route::put('/domestic/{id}', [SppdController::class, 'domesticUpdate'])->name('domestic.update');
        Route::delete('/domestic/{id}', [SppdController::class, 'domesticDestroy'])->name('domestic.destroy');
    });

    // Surat Keluar
    Route::group(['prefix' => 'transaction/outgoing', 'as' => 'transaction.outgoing.'], function () {
        Route::get('/', [OutgoingLetterController::class, 'index'])->name('index');
        Route::get('/create', [OutgoingLetterController::class, 'create'])->name('create');
        Route::post('/', [OutgoingLetterController::class, 'store'])->name('store');
        Route::get('/{letter}/edit', [OutgoingLetterController::class, 'edit'])->name('edit');
        Route::put('/{letter}', [OutgoingLetterController::class, 'update'])->name('update');
        Route::delete('/{letter}', [OutgoingLetterController::class, 'destroy'])->name('destroy');
        Route::get('/export', [ExportLetterController::class, 'exportOutgoing'])->name('export');
    });

    // Attachment
    Route::delete('/attachment', [AttachmentController::class, 'destroy'])->name('attachment.destroy');
});
