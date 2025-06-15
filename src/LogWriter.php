<?php

namespace Larager;

class LogWriter
{
    public static function write($level, $message, $context = [])
    {
        $log = [
            'level' => $level,
            'message' => is_string($message) ? $message : json_encode($message),
            'context' => $context,
            'url' => request()->fullUrl() ?? null,
            'method' => request()->method() ?? null,
            'ip' => request()->ip() ?? null,
            'user_id' => optional(auth()->user())->getAuthIdentifier() ?? null,
            'timestamp' => now()->toIso8601String(),
        ];

        $file = storage_path('logs/larager.log');
        file_put_contents($file, json_encode($log) . PHP_EOL, FILE_APPEND);
    }
}
