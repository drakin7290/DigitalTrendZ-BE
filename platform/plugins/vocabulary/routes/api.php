<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Botble\Vocabulary\Http\Controllers\API',
], function () {
    Route::prefix("vocabulary")->group(function () {
        Route::get("list", "VocabularyController@getListVocabularies");
    });
});
