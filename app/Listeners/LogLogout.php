<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Models\AccessLog;

class LogLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event): void
    {
        $request = request();

        AccessLog::create([
            'user_id' => $event->user?->id,
            'event' => 'logout',
            'email' => $event->user?->email,
            'ip' => $request->ip(),
            'user_agent' => substr((string)$request->userAgent(), 0, 1000),
            'guard' => $event->guard,
            'success' => true,
        ]);
    }
}
