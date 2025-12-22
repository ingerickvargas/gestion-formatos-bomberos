<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\AccessLog;

class LogSuccessfulLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Login $event): void
    {
        $request = request();

        AccessLog::create([
            'user_id' => $event->user->id,
            'event' => 'login',
            'email' => $event->user->email ?? null,
            'ip' => $request->ip(),
            'user_agent' => substr((string)$request->userAgent(), 0, 1000),
            'guard' => $event->guard,
            'success' => true,
        ]);
    }
}
