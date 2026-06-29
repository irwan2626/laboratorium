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
        $requestKey = 'kerusakan_input_'.$kode;

        return view(
            'asisten.create',
            compact('kode', 'peralatan', 'requestKey')
        );
    }

    public function checkByKode(string $kode)
    {
        $kerusakan = Kerusakan::with(['peralatan', 'user'])
            ->whereHas('peralatan', fn ($query) => $query->where('kode_barang', $kode))
            ->latest()
            ->first();

        if (! $kerusakan) {
            return response()->json([
                'exists' => false,
                'create_url' => url('/kerusakan/create/'.rawurlencode($kode)),
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return response()->json([
            'exists' => true,
            'create_url' => url('/kerusakan/create/'.rawurlencode($kode)),
            'detail_url' => url('/kerusakan/'.$kerusakan->id),
            'kerusakan' => [
                'nama_peralatan' => $kerusakan->peralatan->nama_barang ?? '-',
                'kode_peralatan' => $kerusakan->peralatan->kode_barang ?? $kode,
                'laboratorium' => $kerusakan->user->lokasi_lab ?? '-',
                'tanggal' => $kerusakan->tanggal,
                'kategori' => $kerusakan->jenis_kerusakan,
                'status' => $kerusakan->status,
                'deskripsi' => $kerusakan->deskripsi ?: '-',
                'foto_url' => $kerusakan->foto ? Storage::disk('public')->url($kerusakan->foto) : null,
            ],
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
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

    public function show(Kerusakan $kerusakan)
    {
        $kerusakan->load(['peralatan', 'user']);

        return view('asisten.detail-kerusakan', compact('kerusakan'));
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
