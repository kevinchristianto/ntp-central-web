<?php

namespace App\Observers;

use App\Models\Clock;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ClockObserver
{
    /**
     * Handle the Clock "created" event.
     */
    public function created(Clock $clock): void
    {
        $clock->created_by = Auth::id();
        $clock->saveQuietly();

        $log_data = [
            'log_type' => 'add clock',
            'description' => 'New clock "' . $clock->clock_name . '" in line "' . $clock->line->line_name . '" was added by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Clock "updated" event.
     */
    public function updated(Clock $clock): void
    {
        $clock->updated_by = Auth::id();
        $clock->saveQuietly();

        $log_data = [
            'log_type' => 'update clock',
            'description' => 'Clock "' . $clock->clock_name . '" in line "' . $clock->line->line_name . '" was updated by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Clock "deleted" event.
     */
    public function deleted(Clock $clock): void
    {
        $log_data = [
            'log_type' => 'remove clock',
            'description' => 'Clock "' . $clock->clock_name . '" in line "' . $clock->line->line_name . '" was removed by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Clock "restored" event.
     */
    public function restored(Clock $clock): void
    {
        //
    }

    /**
     * Handle the Clock "force deleted" event.
     */
    public function forceDeleted(Clock $clock): void
    {
        //
    }
}
