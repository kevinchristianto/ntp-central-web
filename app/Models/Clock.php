<?php

namespace App\Models;

use App\Observers\ClockObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ClockObserver::class])]
class Clock extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'line_id',
        'clock_name',
        'ip_address',
        'mac_address',
    ];

    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class);
    }
}
