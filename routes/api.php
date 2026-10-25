<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/valuation-log', [
    \App\Http\Controllers\Api\ValuationLogController::class,
    'store'
]);

// The Baileys WhatsApp gateway (whatsapp-service/) pushes messages and receipts here.
// Guarded by the shared WHATSAPP_WEBHOOK_TOKEN, not by a session.
// The default 60/minute API limit is far too low for a message feed, so these
// two swap it for the much higher 'whatsapp-webhook' limiter.
Route::withoutMiddleware('throttle:api')
    ->middleware('throttle:whatsapp-webhook')
    ->group(function () {
        Route::post('/whatsapp/webhook', \App\Http\Controllers\Admin\WhatsAppWebhookController::class)
            ->name('whatsapp.webhook');

        // Same thing, but multipart: a message that arrived with a photo or document.
        Route::post('/whatsapp/webhook/media', [\App\Http\Controllers\Admin\WhatsAppWebhookController::class, 'media'])
            ->name('whatsapp.webhook.media');
    });
