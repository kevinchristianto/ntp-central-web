<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->created_by = Auth::id();
        $user->saveQuietly();

        $log_data = [
            'log_type' => 'add user',
            'description' => 'New user "' . $user->username . '" has been added by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $user->updated_by = Auth::id();
        $user->saveQuietly();

        $log_data = [
            'log_type' => 'update user',
            'description' => 'User "' . $user->username . '" has been updated by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $log_data = [
            'log_type' => 'remove user',
            'description' => 'User "' . $user->username . '" has been deleted by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
