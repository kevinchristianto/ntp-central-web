<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $base = User::whereNotIn('username', ['ADMIN', 'System Scheduler']);

        // Filter by username
        if ($request->username) {
            $base->where('username', 'LIKE', '%' . $request->username . '%');
        }

        // Filter by name
        if ($request->name) {
            $base->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Filter by status
        if ($request->status && $request->status != 'all') {
            $base->where('is_active', $request->status);
        }

        $data = $base->paginate(10);

        return view('pages.users.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:3',
                Rule::unique('users')->where(fn (Builder $query) => $query->whereNull('deleted_at'))
            ],
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        
        $user = new User;
        $user->username = strtoupper($validated['username']);
        $user->name = ucwords($validated['name']);
        $user->password = bcrypt($validated['password']);
        $user->is_active = false;
        $save = $user->save();

        if ($save) {
            return redirect()->route('users.index')->with(['success' => true, 'message' => 'New user created successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to create new user']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:3',
                Rule::unique('users')->ignore($user->id)->where(fn (Builder $query) => $query->whereNull('deleted_at')),
            ],
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);
        $validated['username'] = strtoupper($validated['username']);
        $validated['name'] = ucwords($validated['name']);
        if ($validated['password'] === null) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $update = $user->update($validated);

        if ($update) {
            return redirect()->route('users.index')->with(['success' => true, 'message' => 'User updated successfully']);
        }

        return back()->with(['success' => false, 'message' => 'Failed to update user']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function toggle_status(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $update = $user->updateQuietly($validated);

        $status = $user->is_active ? 'activated' : 'deactivated';
        $log_data = [
            'log_type' => $user->is_active ? 'activate user' : 'deactivate user',
            'description' => 'User "' . $user->username . '" has been ' . $status . ' by ' . Auth::user()->username,
            'actor' => Auth::id(),
            'ip_address' => request()->ip(),
        ];
        Log::create($log_data);

        if ($update) {
            return redirect()->route('users.index')->with(['success' => true, 'message' => 'User ' . $status . ' successfully']);
        }

        return back()->with(['success' => false, 'message' => !$user->is_active ? 'Failed to activate user' : 'Failed to deactivate user']);
    }
}
