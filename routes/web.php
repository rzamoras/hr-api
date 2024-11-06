<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::prefix('pdf')->group(function () {
    Route::get('/test', function () {
        $pdf = Pdf::loadView('app')
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('file.pdf');
        return $pdf->stream();
    });

    Route::get('/v', function () {
        return view('pdf');
    });
    Route::get('/1', function () {
        $pdf = Pdf::loadView('pdf')
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->save('file.pdf');
        return $pdf->stream();
    });
});
