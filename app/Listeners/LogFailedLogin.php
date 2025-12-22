<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Failed;
use App\Models\AccessLog;

class LogFailedLogin
{

    public function __construct()
    {
        //
    }

    public function handle(Failed $event): void
    {
        $request = request();

        AccessLog::create([
            'user_id' => $event->user?->id,
            'event' => 'failed',
            'email' => $event->credentials['email'] ?? null,
            'ip' => $request->ip(),
            'user_agent' => substr((string)$request->userAgent(), 0, 1000),
            'guard' => $event->guard,
            'success' => false,
            'failure_reason' => 'wrong_credentials',
        ]);
    }
}
