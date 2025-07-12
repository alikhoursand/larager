<?php

namespace Larager\Larager;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use function PHPUnit\Framework\isEmpty;
use Larager\Larager\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;

class LaragerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::middleware(config('larager.middleware', []))->get('/debug', [DebugController::class, 'index']);

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'larager');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/larager'),
        ], 'larager-views');

        $this->publishes([
            __DIR__ . '/config/larager.php' => config_path('larager.php'),
        ], 'larager-config');

        $this->registerLogListener();
        config(['logging.default' => 'null']);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/larager.php', 'larager');
    }

    protected function registerLogListener()
    {
        Event::listen(MessageLogged::class, function ($event) {
            $logFile = config('larager.log_file', storage_path('logs/larager.log'));

            // Check if it's an exception
            if (isset($event->context['exception']) && $event->context['exception'] instanceof \Throwable) {
                $e = $event->context['exception'];

                $log = [
                    'timestamp' => now()->toDateTimeString(),
                    'type' => get_class($e),
                    'level' => strtoupper($event->level),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => collect($e->getTrace())->take(10)->toArray(),
                    'context' => null,
                ];
            } else {
                // Normal log

                $log = [
                    'timestamp' => now()->toDateTimeString(),
                    'type' => 'Log',
                    'level' => strtoupper($event->level),
                    'message' => $event->message,
                    'context' => isEmpty($event->context) ? null : $event->context,
                    'trace' => null,
                    'file' => '',
                    'line' => '',
                ];
            }

            file_put_contents($logFile, json_encode($log) . PHP_EOL, FILE_APPEND);
        });
    }
}
