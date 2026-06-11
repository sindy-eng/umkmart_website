<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Customer;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $query = Promo::latest();
        if ($request->search) {
            $query->where('nama_promo', 'like', "%{$request->search}%");
        }
        $promos = $query->paginate(10);
        return view('promos.index', compact('promos'));
    }

    public function create()
    {
        return view('promos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_promo'      => 'required|string|max:255',
            'tipe_diskon'     => 'required|in:persen,nominal',
            'nilai_diskon'    => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable|string',
        ]);
        $validated['aktif'] = true;
        Promo::create($validated);
        return redirect()->route('promos.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        return view('promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'nama_promo'      => 'required|string|max:255',
            'tipe_diskon'     => 'required|in:persen,nominal',
            'nilai_diskon'    => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable|string',
        ]);
        $validated['aktif'] = $request->has('aktif');
        $promo->update($validated);
        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus!');
    }

    public function broadcastView(Promo $promo)
    {
        $customers = Customer::aktif()->whereNotNull('nomor_wa')->get();
        return view('promos.broadcast', compact('promo', 'customers'));
    }

    /**
     * AJAX endpoint: simpan log broadcast setelah semua WA dibuka
     */
    public function broadcastLog(Request $request, Promo $promo)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $promo->update([
            'last_broadcast_at' => now(),
            'broadcast_count'   => $promo->broadcast_count + $request->jumlah,
        ]);

        return response()->json([
            'success'           => true,
            'message'           => 'Log broadcast disimpan.',
            'last_broadcast_at' => $promo->last_broadcast_at->format('d M Y H:i'),
            'broadcast_count'   => $promo->broadcast_count,
        ]);
    }
}
