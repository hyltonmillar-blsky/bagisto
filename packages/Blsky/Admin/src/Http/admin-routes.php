<?php

Route::group(['middleware' => ['web', 'admin']], function () {

            // Bulk Upload Products
            /*Route::get('bulkupload-upload-files', 'Webkul\Bulkupload\Http\Controllers\BulkUploadController@index')->defaults('_config', [
                'view' => 'bulkupload::admin.bulk-upload.upload-files.index'
            ])->name('admin.bulk-upload.index');*/

            Route::get('admin/blsky/configuration/{slug?}/{slug2?}', 'Blsky\Admin\Http\Controllers\ConfigurationController@index')->defaults('_config', [
                'view' => 'admin::blskyconfiguration.index',
            ])->name('blsky.configuration.index');

            Route::post('admin/blsky/configuration/{slug?}/{slug2?}', 'Blsky\Admin\Http\Controllers\ConfigurationController@store')->defaults('_config', [
                'redirect' => 'blsky.configuration.index',
            ])->name('blsky.configuration.index.store');

});