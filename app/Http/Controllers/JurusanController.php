<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();

        return view('admin.master-data.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('admin.master-data.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|max:20|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|max:255',
        ]);

        Jurusan::create([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        return view('admin.master-data.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'kode_jurusan' => 'required|max:20|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required|max:255',
        ]);

        $jurusan->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $jurusan->delete();

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}