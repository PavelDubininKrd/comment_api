<?php

namespace App\Log;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class Logging extends Log
{
    public static function logError(Exception $e, string $driver = 'daily', string $path = null): void
    {
        $path = !$path
            ? storage_path('logs' . '/errors' . '/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . 'error.log')
            : $path;

        Log::build([
            'driver' => $driver,
            'path' => $path,
        ])->error($e->getMessage() . '|' . $e->getFile() . '|' . $e->getLine());
    }
}
