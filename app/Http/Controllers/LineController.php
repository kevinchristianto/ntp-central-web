<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lines = Line::orderBy('code')->get();

        return view('pages.lines.index', compact('lines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:3|unique:lines',
            'line_name' => 'required|string'
        ]);

        $line = new Line();
        $line->code = $validated['code'];
        $line->line_name = $validated['line_name'];
        $save = $line->save();

        if ($save) {
            return redirect()->route('master.lines.index')->with(['success' => true, 'message' => 'Production line saved successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to save production line']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Line $line)
    {
        return response()->json($line->only(['id', 'code', 'line_name']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Line $line)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:3',
                Rule::unique('lines')->ignore($line->id)
            ],
            'line_name' => 'required|string'
        ]);

        $line->code = $validated['code'];
        $line->line_name = $validated['line_name'];
        $update = $line->save();

        if ($update) {
            return redirect()->route('master.lines.index')->with(['success' => true, 'message' => 'Production line updated successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to update production line']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Line $line)
    {
        $line->delete();

        return redirect()->route('master.lines.index')->with(['success' => true, 'message' => 'Production line deleted successfully']);
    }
}
