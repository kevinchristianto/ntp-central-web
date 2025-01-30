<?php

namespace App\Models;

use App\Observers\LineObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([LineObserver::class])]
class Line extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'code',
        'line_name',
    ];
}
