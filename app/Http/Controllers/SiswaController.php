<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    
    public function index()
    {
        $siswas = Siswa::latest('id')->paginate(5);

        return view('admin.master-data.siswa.index', compact('siswas'));
    }

    
    public function create()
    {
        return view('admin.master-data.siswa.create');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Konghucu',
            'nik' => 'nullable|max:20',
            'nama_orang_tua' => 'required|max:255',
            'no_kk' => 'nullable|max:20',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'nama_orang_tua' => 'required|max:255',
            'password' => Hash::make($request->nis),
        ]);

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    
    public function show(string $id)
    {
        
    }

    
    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.master-data.siswa.edit', compact('siswa'));
    }

    
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Konghucu',
            'nik' => 'nullable|max:20',
            'no_kk' => 'nullable|max:20',
            'nama_orang_tua' => 'required|max:255',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'nama_orang_tua' => 'required|max:255',
        ]);

        Siswa::findOrFail($id)->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    
    public function destroy(string $id)
    {
        Siswa::findOrFail($id)->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
