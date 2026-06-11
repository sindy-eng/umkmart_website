<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('transactions');

        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nomor_wa', 'like', "%{$request->search}%");
        }

        $customers = $query->latest()->paginate(12);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');
        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }

    public function riwayat(Customer $customer)
    {
        $transactions = $customer->transactions()->with('details.product', 'promo')->latest()->paginate(10);
        $loyaltyPoints = $customer->loyaltyPoints()->latest()->limit(10)->get();

        return view('customers.riwayat', compact('customer', 'transactions', 'loyaltyPoints'));
    }
}
