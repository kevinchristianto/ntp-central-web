<?php

namespace App\Console\Commands;

use App\Models\Clock;
use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class PingClock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clock:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a ping to each clock to check whether the clock is connected or not';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all clocks, then send 2 ping to all of them in a single command using fping
        $clocks = Clock::with('line')->get()->toArray();
        $addresses = array_column($clocks, 'ip_address');
        $addresses = join(' ', $addresses);
        $command = 'fping -C2 -t500 -q ' . $addresses . ' 2>&1';
        $ping = shell_exec($command);

        // Separate the result by line
        $results = explode("\n", $ping);
        array_pop($results);        // Pop the last array item which is nothing but empty or null item

        foreach ($results as $key => $line) {
            // Separate the result by delimiter
            $line = explode(' : ', $line);
            $address = $line[0];
            $results = $line[1];
            
            // Just a check to see if the IP address matches
            if ($address == $clocks[$key]['ip_address']) {      // IP Matched
                if (str_contains($results, '-')) {              // Clock offline
                    if ($clocks[$key]['is_online']) {           // Clock current state in database is online
                        // Set state to offline, then log the event
                        Clock::where('id', $clocks[$key]['id'])->update(['is_online' => false]);

                        $log_data = [
                            'log_type' => 'clock went offline',
                            'description' => 'Clock "' . $clocks[$key]['clock_name'] . '" in line "' . $clocks[$key]['line']['line_name'] . '" went offline',
                            'actor' => 1,
                            'ip_address' => $address,
                        ];
                        Log::create($log_data);
                    }
                    $this->line($address . ' is offline at ' . date('H:i:s d F Y'));
                } else {
                    if ($clocks[$key]['is_online'] == false) {   // Clock current state in database is offline
                        // Set state to online, then log the event
                        Clock::where('id', $clocks[$key]['id'])->update(['is_online' => true]);

                        $log_data = [
                            'log_type' => 'clock went online',
                            'description' => 'Clock "' . $clocks[$key]['clock_name'] . '" in line "' . $clocks[$key]['line']['line_name'] . '" went online',
                            'actor' => 1,
                            'ip_address' => $address,
                        ];
                        Log::create($log_data);
                    }
                    $this->line($address . ' is online at ' . date('H:i:s d F Y'));
                }
            } else {                                            // IP Mismatched
                $log_data = [
                    'log_type' => 'misc',
                    'description' => 'IP mismatched for address ' . $address . ' and clock IP ' . $clocks[$key]['ip_address'],
                    'actor' => 1,
                    'ip_address' => $address,
                ];
                Log::create($log_data);

                $this->line($address . ' mismatched.');
            }
        }
    }
}
