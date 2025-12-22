<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AccessLog::query()->with('user')->latest();

        // Filtros
        if ($request->filled('event')) {
            $query->where('event', $request->string('event'));
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->string('email') . '%');
        }

        if ($request->filled('ip')) {
            $query->where('ip', 'like', '%' . $request->string('ip') . '%');
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }

        $logs = $query->paginate(15)->withQueryString();

        $events = [
            'login' => 'Login',
            'failed' => 'Fallido',
            'logout' => 'Logout',
            'lockout' => 'Bloqueo (Throttled)',
        ];

        return view('admin.access-logs.index', compact('logs', 'events'));
    }
}
