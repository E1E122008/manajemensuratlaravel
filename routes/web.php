<?php

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

    Route::prefix('transaction')->as('transaction.')->group(function () {
        Route::resource('incoming', \App\Http\Controllers\IncomingLetterController::class);
        Route::resource('outgoing', \App\Http\Controllers\OutgoingLetterController::class);
        Route::resource('{letter}/disposition', \App\Http\Controllers\DispositionController::class)->except(['show']);

        // SPPD Routes
        Route::prefix('sppd')->as('sppd.')->group(function () {
            Route::get('domestic', [\App\Http\Controllers\SppdController::class, 'domestic'])->name('domestic');
            Route::get('foreign', [\App\Http\Controllers\SppdController::class, 'foreign'])->name('foreign');
            Route::resource('domestic', \App\Http\Controllers\DomesticSppdController::class)->except(['index']);
            Route::resource('foreign', \App\Http\Controllers\ForeignSppdController::class)->except(['index']);
        });

        // SPT Routes
        Route::prefix('spt')->as('spt.')->group(function () {
            Route::get('domestic', [\App\Http\Controllers\SptController::class, 'domestic'])->name('domestic');
            Route::get('foreign', [\App\Http\Controllers\SptController::class, 'foreign'])->name('foreign');
            Route::resource('domestic', \App\Http\Controllers\DomesticSptController::class)->except(['index']);
            Route::resource('foreign', \App\Http\Controllers\ForeignSptController::class)->except(['index']);
        });
    });

    // Archive Routes
    Route::prefix('archive')->as('archive.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ArchiveController::class, 'index'])->name('index');
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

});
