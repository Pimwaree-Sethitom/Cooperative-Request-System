<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download-postman', function () {
    $file = public_path('postman/cooperative_api.json');
    if (file_exists($file)) {
        return response()->download($file, 'cooperative_api.json', [
            'Content-Type' => 'application/json',
        ]);
    }
    abort(404);
})->name('download.postman');
