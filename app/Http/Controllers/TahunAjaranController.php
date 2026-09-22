<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::latest('id')->paginate(2);
        return view('admin.master-data.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('admin.master-data.tahun-ajaran.create');
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        return view('admin.master-data.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        TahunAjaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $tahun = TahunAjaran::findOrFail($id);
        $tahun->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->delete();

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil dihapus');
    }
}
