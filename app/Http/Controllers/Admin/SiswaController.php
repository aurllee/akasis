<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();

        return view('admin.master-data.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.master-data.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'alamat' => 'required',
            'nama_orang_tua' => 'required|max:255',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Siswa::create($request->all());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.master-data.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'alamat' => 'required',
            'nama_orang_tua' => 'required|max:255',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $siswa->update($request->all());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
