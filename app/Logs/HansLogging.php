<?php

namespace App\Logs;

use App\Models\ApplicationLog;
use App\Models\SystemLog;
use Illuminate\Http\Request;

trait HansLogging
{
    //capture application log
    public function captureApplicationLog(
        ?int $userId,
        string $email,
        string $event,
        string $eventMessage,
        Request $request
    ) {
        ApplicationLog::create([
            'user_id' => $userId,
            'email' => $email,
            'ip_address' => $request->ip(),
            'event' => $event,
            'event_message' => $eventMessage,
            'user_agent' => $request->header('User-Agent'),
            'url' => $request->fullUrl(),
            'recorded_at' => now()
        ]);
    }
    //capture system log
    public function captureSystemLog(
        ?int $userId,
        ?string $email,
        string $event,
        string $eventMessage,
        Request $request
    ) {
        SystemLog::create([
            'user_id' => $userId,
            'email' => $email,
            'ip_address' => $request->ip(),
            'event' => $event,
            'event_message' => $eventMessage,
            'user_agent' => $request->header('User-Agent'),
            'url' => $request->fullUrl(),
            'recorded_at' => now()
        ]);
    }
}
