<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotTelegramController;

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

Route::get('/', function () {
    return 'Hello server';
});
Route::get('telegram/webhooks', [BotTelegramController::class, 'inbound']);
Route::get('setWebhook', [BotTelegramController::class, 'setWebhook']);
Route::post('Faozitele_bot/webhooks', [BotTelegramController::class, 'inbound']);