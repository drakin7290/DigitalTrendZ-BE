<?php

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Vocabulary\Models\Vocabulary;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Vocabulary\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'vocabularies', 'as' => 'vocabulary.'], function () {
            Route::resource('', 'VocabularyController')->parameters(['' => 'vocabulary']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'VocabularyController@deletes',
                'permission' => 'vocabulary.destroy',
            ]);
        });
    });
});
