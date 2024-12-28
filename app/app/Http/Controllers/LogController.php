<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Retrieve the logs
        $logs = $this->getFilteredLogs($request->input('search'), $request->input('date'));


        return view('logs', ['logs' => $logs]);
    }

    private function getFilteredLogs($search, $date)
    {
        // Read the log file
        $logFilePath = storage_path('logs/laravel.log');
        $logContents = file_get_contents($logFilePath);
        
        // Extract the log entries
        $pattern = '/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] local\.INFO:.*/m';
        preg_match_all($pattern, $logContents, $matches);
        
        // Filter the log entries based on search query and date
        $logs = collect($matches[0])->filter(function ($logEntry) use ($search, $date) {
            // Apply search query filter
            if ($search && stripos($logEntry, $search) === false) {
                return false;
            }
            
            // Apply date filter
            if ($date && strpos($logEntry, $date) === false) {
                return false;
            }
            
            return true;
        });
        
        return $logs->toArray();
    }
}
