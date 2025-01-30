<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use App\Models\Line;
use Illuminate\Http\Request;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Clock::with('line')->paginate(10);
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
}
