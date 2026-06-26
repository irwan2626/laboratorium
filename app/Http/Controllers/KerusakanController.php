<?php
namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Laboratorium;


class KerusakanController extends Controller
{
    public function dashboard()
    {
        $total = Kerusakan::count();
        $totalPerJenis = Kerusakan::countByJenis();

        $kerusakanTerbaru = Kerusakan::withPeralatan()
            ->latest()
            ->take(5)
            ->get();

        return view('asisten.dashboard', compact('total', 'totalPerJenis', 'kerusakanTerbaru'));
    }


    public function scan()
    {
        return view('asisten.scan');
    }

    public function create($kode)
    {
        $peralatan = Peralatan::where('kode_barang', $kode)->first();

        return view(
            'asisten.create',
            compact('kode', 'peralatan')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => ['required', 'string', 'max:255'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis_kerusakan' => ['required', Rule::in(Kerusakan::JENIS_KERUSAKAN)],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image'],
        ]);

        $kondisi = $request->jenis_kerusakan === 'Tidak Bisa Digunakan'
            ? 'Tidak Bisa Digunakan'
            : 'Rusak';

        $foto = null;

        if($request->hasFile('foto'))
        {
            $foto =
            $request->file('foto')
            ->store(
                'kerusakan',
                'public'
            );
        }

        $peralatan = Peralatan::updateOrCreate(
            ['kode_barang' => $request->kode_barang],
            [
                'nama_barang' => $request->nama_barang,
                'kondisi' => $kondisi,
                'qr_code' => $request->kode_barang,
            ]
        );

        Kerusakan::create([

            'peralatan_id' =>
            $peralatan->id,

            'user_id' =>
            auth()->user()->id,

            'jenis_kerusakan' =>
            $request->jenis_kerusakan,

            'deskripsi' =>
            $request->deskripsi,

            'foto' => $foto,

            'status' => 'Rusak',

            'tanggal' => now()
        ]);

        return redirect('/data-kerusakan')
        ->with(
            'success',
            'Kerusakan berhasil disimpan'
        );
    }

    public function dataKerusakan()
    {
        $kerusakan = Kerusakan::withPeralatan()
            ->latest()
            ->get();

        return view(
            'asisten.data-kerusakan',
            compact('kerusakan')
        );
    }

    public function edit(Kerusakan $kerusakan)
    {
        $kerusakan->load('peralatan');

        return view(
            'asisten.edit-kerusakan',
            compact('kerusakan')
        );
    }

    public function update(Request $request, Kerusakan $kerusakan)
    {
        $kerusakan->load('peralatan');

        $request->validate([
            'kode_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('peralatans', 'kode_barang')->ignore($kerusakan->peralatan_id),
            ],
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis_kerusakan' => ['required', Rule::in(Kerusakan::JENIS_KERUSAKAN)],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'foto' => ['nullable', 'image'],
        ]);

        $kondisi = $request->jenis_kerusakan === 'Tidak Bisa Digunakan'
            ? 'Tidak Bisa Digunakan'
            : 'Rusak';

        $kerusakan->peralatan->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kondisi' => $kondisi,
            'qr_code' => $request->kode_barang,
        ]);

        $foto = $kerusakan->foto;

        if ($request->hasFile('foto')) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            $foto = $request->file('foto')->store('kerusakan', 'public');
        }

        $kerusakan->update([
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => $request->status,
            'tanggal' => $request->tanggal,
        ]);

        return redirect('/data-kerusakan')
            ->with('success', 'Data kerusakan berhasil diperbarui');
    }

    public function destroy(Kerusakan $kerusakan)
    {
        if ($kerusakan->foto) {
            Storage::disk('public')->delete($kerusakan->foto);
        }

        $kerusakan->delete();

        return redirect('/data-kerusakan')
            ->with('success', 'Data kerusakan berhasil dihapus');
    }

    public function laporan()
    {
        $kerusakan = Kerusakan::withPeralatan()
            ->latest()
            ->get();

        return view('admin.laporan.index', compact('kerusakan'));
    }

}
