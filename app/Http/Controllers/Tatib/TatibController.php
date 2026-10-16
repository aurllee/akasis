<?php

namespace App\Http\Controllers\Tatib;

use App\Http\Controllers\Controller;
use App\Models\Siswatatib;
use App\Models\Siswa;
use App\Models\Tatib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TatibController extends Controller
{
    public function index()
    {
        $pelanggaran = Tatib::query()
            ->orderBy('jenis_pelanggaran')
            ->paginate(15);

        return view(
            'Tatib.datapelanggaran.index',
            compact('pelanggaran')
        );
    }

    public function create()
    {
        // Ambil kembali siswa jika validasi form sebelumnya gagal.
        $oldSiswa = old('siswa', []);

        $selectedIds = collect($oldSiswa)
            ->pluck('id')
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $selectedSiswa = Siswa::query()
            ->whereIn('id', $selectedIds)
            ->orderBy('nama')
            ->get(['id', 'nama', 'nis']);

        $jenisPelanggaran = Tatib::query()
            ->orderBy('jenis_pelanggaran')
            ->get(['id', 'jenis_pelanggaran', 'poin_pelanggaran', 'kategori']);

        $violations = $jenisPelanggaran->map(function ($item) {
            return [
                'id' => (string) $item->id,
                'nama' => $item->jenis_pelanggaran,
                'poin' => $item->poin_pelanggaran,
                'kategori' => $item->kategori ?: 'Lainnya',
            ];
        })->values()->all();

        return view(
            'Tatib.datapelanggaran.create',
            compact('selectedSiswa', 'jenisPelanggaran', 'oldSiswa', 'violations')
        );
    }

    public function searchSiswa(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $siswa = Siswa::query()
            ->where(function ($query) use ($term) {
                $query->where('nama', 'like', "%{$term}%")
                    ->orWhere('nis', 'like', "%{$term}%");
            })
            ->orderBy('nama')
            ->limit(20)
            ->get(['id', 'nama', 'nis']);

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $siswaTable = (new Siswa())->getTable();
        $tatibTable = (new Tatib())->getTable();

        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'pelanggaran_utama' => [
                'nullable',
                'integer',
                Rule::exists($tatibTable, 'id'),
],
            'siswa' => ['required', 'array', 'min:1'],
            'siswa.*.id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists($siswaTable, 'id'),
            ],
            'siswa.*.pelanggaran' => [
                'required',
                'array',
                'min:1',
            ],
            'siswa.*.pelanggaran.*' => [
                'required',
                'integer',
                Rule::exists($tatibTable, 'id'),
            ],
        ], [
            'tanggal.required' => 'Tanggal pencatatan wajib diisi.',
            'siswa.required' => 'Tambahkan minimal satu siswa.',
            'siswa.min' => 'Tambahkan minimal satu siswa.',
            'siswa.*.id.required' => 'Data siswa tidak valid.',
            'siswa.*.id.distinct' => 'Siswa yang sama tidak boleh dimasukkan dua kali.',
            'siswa.*.pelanggaran.required' => 'Pilih minimal satu pelanggaran untuk setiap siswa.',
            'siswa.*.pelanggaran.min' => 'Setiap siswa harus memiliki minimal satu pelanggaran.',
        ]);

        foreach ($validated['siswa'] as $index => $dataSiswa) {
    $ids = array_map('strval', $dataSiswa['pelanggaran']);

    if (count($ids) !== count(array_unique($ids))) {
        return back()
            ->withErrors([
                "siswa.{$index}.pelanggaran" =>
                    'Pelanggaran yang sama tidak boleh dipilih dua kali untuk siswa yang sama.',
            ])
            ->withInput();
    }
}

        $siswaIds = collect($validated['siswa'])->pluck('id')->all();
        $tatibIds = collect($validated['siswa'])
            ->flatMap(fn($siswa) => $siswa['pelanggaran'] ?? [])
            ->unique()
            ->values()
            ->all();

        $validTatibIds = Tatib::query()
            ->whereIn('id', $tatibIds)
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();

        $missingTatibIds = collect($tatibIds)
            ->map(fn($id) => (int) $id)
            ->diff($validTatibIds)
            ->values()
            ->all();

        if (!empty($missingTatibIds)) {
            return back()
                ->withErrors([
                    'siswa' => 'Terdapat ID pelanggaran yang tidak valid.',
                ])
                ->withInput();
        }

        $jumlahCatatan = 0;

        DB::transaction(function () use ($validated, &$jumlahCatatan) {
            foreach ($validated['siswa'] as $dataSiswa) {
                $siswaId = (int) $dataSiswa['id'];
                $pelanggaranIds = collect($dataSiswa['pelanggaran'] ?? [])
                    ->map(fn($id) => (int) $id)
                    ->unique()
                    ->values()
                    ->all();

                foreach ($pelanggaranIds as $tatibId) {
                    Siswatatib::create([
                        'id_siswa' => $siswaId,
                        'id_tatib' => $tatibId,
                        'tanggal' => $validated['tanggal'],
                        'keterangan' => null,
                    ]);

                    $jumlahCatatan++;
                }
            }
        });

        return redirect()
            ->route('tatib.riwayat')
            ->with(
                'success',
                "Berhasil menyimpan {$jumlahCatatan} catatan pelanggaran."
            );
    }

    public function riwayat()
    {
        $riwayat = Siswatatib::with(['siswa', 'tatib'])
            ->orderByDesc('tanggal')
            ->paginate(15);

        return view('Tatib.riwayat.index', compact('riwayat'));
    }
}
