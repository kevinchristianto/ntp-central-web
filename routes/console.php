<?php

use App\Console\Commands\PingClock;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('clock:ping')->everyTenMinutes()->appendOutputTo('./storage/logs/scheduler-log.txt');