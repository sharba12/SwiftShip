<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    // Show all agents
    public function index()
    {
        $agents = User::where('role', 'agent')->get();
        return view('admin.agents.index', compact('agents'));
    }

    // Show form to create agent
    public function create()
    {
        return view('admin.agents.create');
    }

    // Store new agent
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'agent',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.agents.index')->with('success', 'Agent added successfully!');
    }

    // Show single agent (redirect to index — no detail page needed)
    public function show($id)
    {
        return redirect()->route('admin.agents.index');
    }

    // Show edit form
    public function edit($id)
    {
        $agent = User::where('role', 'agent')->findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    // Update agent
    public function update(Request $request, $id)
    {
        $agent = User::where('role', 'agent')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $agent->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $agent->update($data);

        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully!');
    }

    // Delete agent
    public function destroy($id)
    {
        User::where('role', 'agent')->findOrFail($id)->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully!');
    }
}
