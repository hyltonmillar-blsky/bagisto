<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('payfast')->group(function () {

        Route::get('/redirect', 'Blsky\Payfast\Http\Controllers\PayfastController@redirect')->name('payfast.redirect');

        Route::get('/success', 'Blsky\Payfast\Http\Controllers\PayfastController@success')->name('payfast.success');

        Route::get('/cancel', 'Blsky\Payfast\Http\Controllers\PayfastController@cancel')->name('payfast.cancel');

        Route::post('/itn', 'Blsky\Payfast\Http\Controllers\PayfastController@itn')->name('payfast.itn');
    });
});
