<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BotTelegramController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('telegram/webhooks')->group(function() {
    // Route::post('inbound',function(Request $request) {
    //     log::info($request->all());
    // });

    Route::post('inbound',[BotTelegramController::class,'inbound'])->name('telegram.inbound');
});

//https://api.telegram.org/bot6899260953:AAGncVBPw3gjrCjhUgZQIaLZ94QNb_j50g4/setWebhook?url=https://f07c-36-90-6-48.ngrok-free.app/api/telegram/webhooks/inbound


