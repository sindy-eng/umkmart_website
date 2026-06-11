<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('user');

        if ($request->search) {
            $query->where('keterangan', 'like', "%{$request->search}%")
                ->orWhere('kategori', 'like', "%{$request->search}%");
        }
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        $expenses = $query->latest('tanggal')->paginate(15);
        $totalBulanIni = Expense::whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->sum('jumlah');
        $kategoris = ['Bahan Baku', 'Gaji Karyawan', 'Listrik & Air', 'Sewa Tempat', 'Operasional', 'Lainnya'];

        return view('expenses.index', compact('expenses', 'totalBulanIni', 'kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        $kategoris = ['Bahan Baku', 'Gaji Karyawan', 'Listrik & Air', 'Sewa Tempat', 'Operasional', 'Lainnya'];
        return view('expenses.edit', compact('expense', 'kategoris'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
