<?php
// App\Listeners\CustomizeRateLimitExceededResponse.php
namespace App\Listeners;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Response;

class CustomizeRateLimitExceededResponse
{
    public function handle(RouteMatched $event)
    {
        if ($event->request->is('api/*')) {
            return Response::json(['message' => 'Rate limit exceeded.'], 429);
        }
    }
}
