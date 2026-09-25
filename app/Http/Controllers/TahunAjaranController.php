<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TahunAjaranController extends Controller
{
    public function index(): View
    {
        $tahunAjaran = TahunAjaran::query()
            ->orderByDesc('tahun_ajaran')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.master-data.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create(): View
    {
        return view('admin.master-data.tahun-ajaran.create');
    }

    public function edit($id): View
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        return view('admin.master-data.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        TahunAjaran::create([
            'tahun_ajaran' => $validated['tahun_ajaran'],
            'semester' => $validated['semester'],
            'status' => $request->boolean('status'),
        ]);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $tahun = TahunAjaran::findOrFail($id);
        $tahun->update([
            'tahun_ajaran' => $validated['tahun_ajaran'],
            'semester' => $validated['semester'],
            'status' => $request->boolean('status'),
        ]);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse
    {
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->delete();

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Data tahun ajaran berhasil dihapus');
    }

    protected function rules(): array
    {
        return [
            'tahun_ajaran' => ['required', 'string', 'max:9'],
            'semester' => ['required', 'in:Ganjil,Genap'],
        ];
    }
}
