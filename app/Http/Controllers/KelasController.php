<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function index(Request $request)
    {
        $jurusans = Jurusan::query()
            ->orderBy('kode_jurusan')
            ->orderBy('nama_jurusan')
            ->get();

        $kelases = Kelas::with(['jurusan', 'waliKelas', 'tahunAjaran'])
            ->select('kelas.*')
            ->join('jurusan', 'jurusan.id', '=', 'kelas.jurusan_id')
            ->orderBy('jurusan.kode_jurusan')
            ->orderBy('jurusan.nama_jurusan')
            ->orderByRaw("CASE kelas.tingkat WHEN 'X' THEN 1 WHEN 'XI' THEN 2 WHEN 'XII' THEN 3 ELSE 4 END")
            ->orderBy('kelas.nama_kelas')
            ->when($request->filled('jurusan_id'), function ($query) use ($request) {
                $query->where('kelas.jurusan_id', $request->jurusan_id);
            })
            ->paginate(10)
            ->appends($request->query());

        return view('admin.master-data.kelas.index', compact('kelases', 'jurusans'));
    }


    public function create()
    {
        $gurus = Guru::all();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjarans = TahunAjaran::all();

        return view('admin.master-data.kelas.create', compact('gurus', 'jurusans', 'tahunAjarans'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|in:A,B,C,D,E,F,G,H',
            'wali_kelas_id' => 'required|exists:dataguru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }


    public function show(string $id) {}


    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::all();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjarans = TahunAjaran::all();

        return view('admin.master-data.kelas.edit', compact('kelas', 'gurus', 'jurusans', 'tahunAjarans'));
    }


    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|in:A,B,C,D,E,F,G,H',
            'wali_kelas_id' => 'nullable|exists:dataguru,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajaran,id',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->fill($data);
        $kelas->save();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        Kelas::findOrFail($id)->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
