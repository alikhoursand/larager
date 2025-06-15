<?php

namespace Alikhoursand\Larager\Http\Controllers;

use Illuminate\Routing\Controller;

class DebugController extends Controller
{
    public function index()
    {
        $logFile = config('larager.log_file', storage_path('logs/larager.log'));

        if (!file_exists($logFile)) {
            $logs = [];
        } else {
            $contents = file_get_contents($logFile);
            $lines = array_filter(explode(PHP_EOL, $contents));

            $logs = [];
            foreach ($lines as $line) {
                $decoded = json_decode($line);
                if ($decoded) {
                    $logs[] = $decoded;
                }
            }

            $logs = array_reverse($logs); // Newest first
        }


        foreach ($logs as $log) {
            $log->type = $this->translateException($log->type);
        }

        return view('larager::debug', compact('logs'));
    }


    function translateException($e): string
    {
        $map = [
            'Illuminate\Database\QueryException' => 'Database query error',
            'Illuminate\Auth\AuthenticationException' => 'Authentication failed',
            'Symfony\Component\HttpKernel\Exception\NotFoundHttpException' => 'Page not found',
            'Illuminate\Validation\ValidationException' => 'Validation failed',
            'Illuminate\Session\TokenMismatchException' => 'Security token mismatch',
            'ErrorException' => 'PHP error',
            'TypeError' => 'Type error in code',
            'Exception' => 'Application error',
            'Throwable' => 'System error',
        ];

        foreach ($map as $class => $message) {
            if (str_contains($e, $class)) {
                return $message;
            }
        }

        return $e;
    }


}
