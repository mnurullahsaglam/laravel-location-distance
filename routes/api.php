<?php

use App\Http\Controllers\Api\V1\LocationController;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('/locations', LocationController::class);
});
