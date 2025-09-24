<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('category')->orderBy('name')->paginate(12);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'is_prescription_only' => 'sometimes|boolean',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:2000',
        ]);

        $data['is_prescription_only'] = (bool) ($data['is_prescription_only'] ?? false);
        $data['slug'] = $this->uniqueSlug($data['name']);

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil dibuat.');
    }

    public function addStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate(['qty' => 'required|integer|min:1']);
        $medicine->increment('stock', $validated['qty']);

        return back()->with('success', "Stok '{$medicine->name}' bertambah {$validated['qty']}.");
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 2;
        while (Medicine::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
