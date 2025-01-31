<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function user_logs(Request $request)
    {
        $base = Log::whereIn('log_type', ['add user', 'remove user', 'update user', 'activate user', 'deactivate user', 'sign in', 'sign out']);

        // Filter by type
        if ($request->type && $request->type != 'all') {
            $base->where('log_type', $request->type);
        }

        // Filter by actor
        if ($request->actor) {
            if ($request->actor == '-') {
                $base->whereNull('actor');
            } else {
                $base->whereHas('actor_detail', function (Builder $query) use ($request) {
                    $query->where('username', strtoupper($request->actor));
                });
            }
        }

        // Filter by IP Address
        if ($request->ip_address) {
            $base->where('ip_address', $request->ip_address);
        }

        // Filter by date range
        if ($request->date_start) {
            $date_end = $request->date_end ?? date('Y-m-d');
            $base->whereBetween(DB::raw('date(created_at)'), [$request->date_start, $date_end]);
        }

        $data = $base->with('actor_detail')->orderByDesc('created_at')->paginate(10);

        return view('pages.logs.user', compact('data'));
    }

    public function clock_logs(Request $request)
    {
        $base = Log::whereIn('log_type', ['add clock', 'remove clock', 'update clock', 'configure clock']);

        // Filter by type
        if ($request->type && $request->type != 'all') {
            $base->where('log_type', $request->type);
        }

        // Filter by actor
        if ($request->actor) {
            if ($request->actor == '-') {
                $base->whereNull('actor');
            } else {
                $base->whereHas('actor_detail', function (Builder $query) use ($request) {
                    $query->where('username', strtoupper($request->actor));
                });
            }
        }

        // Filter by IP Address
        if ($request->ip_address) {
            $base->where('ip_address', $request->ip_address);
        }

        // Filter by date range
        if ($request->date_start) {
            $date_end = $request->date_end ?? date('Y-m-d');
            $base->whereBetween(DB::raw('date(created_at)'), [$request->date_start, $date_end]);
        }

        $data = $base->with('actor_detail')->orderByDesc('created_at')->paginate(10);

        return view('pages.logs.clock', compact('data'));
    }
}
