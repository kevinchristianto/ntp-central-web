<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'log_type',
        'description',
        'actor',
        'ip_address',
    ];
}
