<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function user_logs(Request $request)
    {
        $data = Log::whereIn('log_type', ['add user', 'remove user', 'update user', 'activate user', 'deactivate user', 'sign in', 'sign out'])->paginate(10);

        return view('pages.logs.user', compact('data'));
    }
}
