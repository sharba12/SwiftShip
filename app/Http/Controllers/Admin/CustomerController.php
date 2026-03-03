<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display customer list with search, sort, pagination.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('address', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Sorting
        if ($request->sort == 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort == 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $customers = $query->paginate(10)->appends($request->query());

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show form for create (not used because you're using modal)
     */
    public function create()
    {
        return view('admin.customers.create'); // optional
    }

    /**
     * Store new customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->only('name', 'email', 'phone', 'address'));

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer added successfully!');
    }

    /**
     * Edit customer.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update customer.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->only('name', 'email', 'phone', 'address'));

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Delete customer.
     */
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
