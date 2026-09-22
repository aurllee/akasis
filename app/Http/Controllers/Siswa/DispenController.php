<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DispenController extends Controller
{


    private function siswaLogin()
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $siswa = Siswa::where('nis', $user->username)->first();

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        return $siswa;
    }




    public function index(Request $request)
    {
        $siswa = $this->siswaLogin();

        $query = Dispen::where('siswa_id', $siswa->id);



        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('alasan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }




        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }




        $dispensasi = $query
            ->latest('created_at')
            ->paginate(10)
            ->appends($request->query());


        return view(
            'siswa.dispen.index',
            compact(
                'dispensasi',
                'siswa'
            )
        );
    }




    public function create()
    {
        $siswa = $this->siswaLogin();

        return view(
            'siswa.dispen.create',
            compact('siswa')
        );
    }




    public function store(Request $request)
    {
        $siswa = $this->siswaLogin();



        $data = $request->validate([

            'tanggal_mulai' => [
                'required',
                'date',
            ],

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'kegiatan' => [
                'required',
                'string',
                'max:255',
            ],

            'alasan' => [
                'required',
                'string',
                'max:1000',
            ],

            'surat' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],

        ]);




        $namaSurat = null;

        if ($request->hasFile('surat')) {

            $namaSurat = $request->file('surat')
                ->store('dispen', 'public');
        }




        $dispen = new Dispen();

        $dispen->siswa_id = $siswa->id;

        $dispen->tanggal_mulai =
            $data['tanggal_mulai'];

        $dispen->tanggal_selesai =
            $data['tanggal_selesai'];

        $dispen->kegiatan =
            $data['kegiatan'];

        $dispen->alasan =
            $data['alasan'];

        $dispen->surat =
            $namaSurat;

        $dispen->status =
            'disetujui';

        $dispen->save();




        return redirect()
            ->route('siswa.dispen.index')
            ->with(
                'success',
                'Pengajuan dispensasi berhasil disimpan.'
            );
    }




    public function show($id)
    {
        $siswa = $this->siswaLogin();



        $dispen = Dispen::where(
            'siswa_id',
            $siswa->id
        )->findOrFail($id);


        return view(
            'siswa.dispen.show',
            compact(
                'dispen',
                'siswa'
            )
        );
    }
}
