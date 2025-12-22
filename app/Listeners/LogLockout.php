<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Lockout;
use App\Models\AccessLog;

class LogLockout
{
    public function __construct()
    {
        //
    }

    public function handle(Lockout $event): void
    {
        $request = $event->request;

        AccessLog::create([
            'user_id' => null,
            'event' => 'lockout',
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => substr((string)$request->userAgent(), 0, 1000),
            'guard' => null,
            'success' => false,
            'failure_reason' => 'throttled',
        ]);
    }
}
