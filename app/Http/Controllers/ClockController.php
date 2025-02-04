<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use App\Models\Line;
use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $base = Clock::with('line');

        // Filter by line
        if ($request->line && $request->line != 'all') {
            $base->where('line_id', $request->line);
        }

        // Filter by clock_name
        if ($request->name) {
            $base->where('clock_name', 'LIKE', '%' . $request->name . '%');
        }

        // Filter by IP Address
        if ($request->ip) {
            $base->where('ip_address', $request->ip);
        }

        // Filter by MAC Address
        if ($request->mac) {
            $base->where('mac_address', $request->mac);
        }

        // Filter by status
        if ($request->status && $request->status != 'all') {
            $base->where('is_online', $request->status);
        }

        $data = $base->orderByDesc('created_at')->paginate(10)->withQueryString();
        $lines = Line::all();

        return view('pages.clocks.index', compact('data', 'lines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'clock_name' => 'required|string',
            'ip_address' => 'required|ipv4',
            'mac_address' => 'required|mac_address',
        ]);

        $clock = new Clock;
        $clock->line_id = $validated['line_id'];
        $clock->clock_name = $validated['clock_name'];
        $clock->ip_address = $validated['ip_address'];
        $clock->mac_address = $validated['mac_address'];
        $save = $clock->save();

        if ($save) {
            return redirect()->route('clocks.index')->with(['success' => true, 'message' => 'New clock saved successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to save new clock']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clock $clock)
    {
        return response()->json($clock->only(['id', 'line_id', 'clock_name', 'ip_address', 'mac_address']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clock $clock)
    {
        $validated = $request->validate([
            'line_id' => 'required|exists:lines,id',
            'clock_name' => 'required|string',
            'ip_address' => 'required|ipv4',
            'mac_address' => 'required|mac_address',
        ]);

        $clock->line_id = $validated['line_id'];
        $clock->clock_name = $validated['clock_name'];
        $clock->ip_address = $validated['ip_address'];
        $clock->mac_address = $validated['mac_address'];
        $save = $clock->save();

        if ($save) {
            return redirect()->route('clocks.index')->with(['success' => true, 'message' => 'Clock updated successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to update clock']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clock $clock)
    {
        $clock->delete();

        return redirect()->route('clocks.index')->with(['success' => true, 'message' => 'Clock deleted successfully']);
    }

    public function configure(Request $request)
    {
        $clock = Clock::find($request->id);
        $log_data = [
            'log_type' => 'add clock',
            'description' => 'Clock "' . $clock->clock_name . '" in line "' . $clock->line->line_name . '" was configured ' . $request->user()->username,
            'actor' => $request->user()->id,
            'ip_address' => $request->ip(),
        ];
        Log::create($log_data);

        return redirect('http://' . $clock->ip_address . ':1880');
    }
}
