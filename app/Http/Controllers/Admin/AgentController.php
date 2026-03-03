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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'agent', // assign role as agent
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.agent.index')->with('success', 'Agent added successfully!');
    }
}
