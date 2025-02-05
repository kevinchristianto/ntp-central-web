<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use App\Models\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the next due time for the clock ping from the console command
        $exec = shell_exec('php /var/www/artisan schedule:list 2>&1');
        $results = explode("\n", $exec);
        $matched_command = array_values(array_filter($results, function ($item) {
            return str_contains($item, 'clock:ping');
        }))[0];
        preg_match('/ [0-9]{1,2} [a-z]* /i', $matched_command, $next_due);        // Make sure the space in the regex is there and not removed
        $next_due = trim($next_due[0]);

        $clocks = Clock::all();
        $online_clocks = $clocks->filter(function ($clock) {
            return $clock->is_online;
        })->count();
        $offline_clocks = $clocks->filter(function ($clock) {
            return !$clock->is_online;
        })->count();
        $offline_clocks_today = Log::where('log_type', 'clock went offline')->where('created_at', '>=', date('Y-m-d'))->groupBy('ip_address')->count();

        $inspiring_quote_lol = Inspiring::quote();

        return view('pages.dashboard', compact('next_due', 'clocks', 'online_clocks', 'offline_clocks', 'offline_clocks_today', 'inspiring_quote_lol'));
    }
}
