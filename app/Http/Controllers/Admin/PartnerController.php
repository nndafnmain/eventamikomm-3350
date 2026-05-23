<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $partners = Partner::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })->latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required|image|mimes:jpg,jpeg,png,webp'
        ]);

        $logoPath = $request
            ->file('logo_url')
            ->store('partners', 'public');

        Partner::create([
            'name' => $request->name,
            'logo_url' => $logoPath
        ]);

        return redirect()->back()->with('success', 'Partner berhasil ditambahkan');
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $data = [
            'name' => $request->name
        ];

        if ($request->hasFile('logo_url')) {

            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }

            $data['logo_url'] = $request
                ->file('logo_url')
                ->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()->back()->with('success', 'Partner berhasil diupdate');
    }

    public function destroy(Partner $partner)
    {
        // hapus file logo dari storage
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }

        // hapus data dari database
        $partner->delete();

        return redirect()->back()->with('success', 'Partner berhasil dihapus');
    }
}