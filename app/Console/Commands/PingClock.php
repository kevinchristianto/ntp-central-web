<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;

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
        $log_data = [
            'log_type' => 'configure clock',
            'description' => 'test',
            'actor' => null,
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);

        return $this->line('Ping clock executed successfully');
    }
}
