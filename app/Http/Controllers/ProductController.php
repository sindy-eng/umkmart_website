<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('nama_produk', 'like', "%{$request->search}%");
        }
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->latest()->paginate(12);
        $kategoris = Product::distinct()->pluck('kategori')->sort()->values();

        return view('products.index', compact('products', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Product::distinct()->pluck('kategori')->sort()->values();
        return view('products.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $validated['gambar_produk'] = $request->file('gambar_produk')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $kategoris = Product::distinct()->pluck('kategori')->sort()->values();
        return view('products.edit', compact('product', 'kategoris'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'aktif' => 'boolean',
        ]);

        if ($request->hasFile('gambar_produk')) {
            if ($product->gambar_produk) {
                Storage::disk('public')->delete($product->gambar_produk);
            }
            $validated['gambar_produk'] = $request->file('gambar_produk')->store('products', 'public');
        }

        $validated['aktif'] = $request->has('aktif');
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar_produk) {
            Storage::disk('public')->delete($product->gambar_produk);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteImage(Product $product)
    {
        if ($product->gambar_produk) {
            Storage::disk('public')->delete($product->gambar_produk);
            $product->update(['gambar_produk' => null]);
        }
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
