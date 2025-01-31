<?php

namespace App\Observers;

use App\Models\Line;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LineObserver
{
    /**
     * Handle the Line "created" event.
     */
    public function created(Line $line): void
    {
        $line->created_by = Auth::id();
        $line->saveQuietly();

        $log_data = [
            'log_type' => 'add line',
            'description' => 'New production line "' . $line->line_name . '" was added by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Line "updated" event.
     */
    public function updated(Line $line): void
    {
        $line->updated_by = Auth::id();
        $line->saveQuietly();

        $log_data = [
            'log_type' => 'update line',
            'description' => 'Production line "' . $line->line_name . '" was updated by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Line "deleted" event.
     */
    public function deleted(Line $line): void
    {
        $log_data = [
            'log_type' => 'remove line',
            'description' => 'Production line "' . $line->line_name . '" was removed by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the Line "restored" event.
     */
    public function restored(Line $line): void
    {
        //
    }

    /**
     * Handle the Line "force deleted" event.
     */
    public function forceDeleted(Line $line): void
    {
        //
    }
}
