<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
 //   return $request->user();
//});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('throttle:10,1')->group(function () {
    Route::get('verify-certificate/{certificateNo}', [CertificateController::class, 'verifyCertificate']);
});


//eccDqTtZW6Mi0rqw0Md6DiPYjkcZbTJrHopZg6s8jFdiBLWcrNkIrBCWs43N
//eccDqTtZW6Mi0rqw0Md6DiPYjkcZbTJrHopZg6s8jFdiBLWcrNkIrBCWs43N
//Route::get('/verify-certificate/{certificateNo}', [CertificateController::class, 'verifyCertificate']);