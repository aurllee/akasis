<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::paginate(10);

        return view('admin.master-data.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('admin.master-data.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ruang' => 'required',
            'nama_ruang' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        Ruangan::create([
            'kode_ruang' => $request->kode_ruang,
            'nama_ruang' => $request->nama_ruang,
            'kapasitas' => $request->kapasitas,
            'status' => $request->boolean('status'),
        ]);

        return redirect('/admin/ruangan')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        return view('admin.master-data.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_ruang' => 'required',
            'nama_ruang' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $ruangan = Ruangan::findOrFail($id);

        $ruangan->update([
            'kode_ruang' => $request->kode_ruang,
            'nama_ruang' => $request->nama_ruang,
            'kapasitas' => $request->kapasitas,
            'status' => $request->boolean('status'),
        ]);

        return redirect('/admin/ruangan')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $ruangan->delete();

        return redirect('/admin/ruangan')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
