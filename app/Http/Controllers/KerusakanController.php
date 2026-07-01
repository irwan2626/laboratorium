<?php
namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\Laboratorium;


class KerusakanController extends Controller
{
    public function foto(string $path)
    {
        $path = urldecode(trim($path, '/'));

        $resolvedPath = $this->resolveFotoPath($path);

        abort_unless($resolvedPath, 404);

        return response()->file($resolvedPath);
    }

    private function resolveFotoPath(string $path): ?string
    {
        $candidates = [
            base_path('uploads/' . $path),
            base_path('public/uploads/' . $path),
            base_path('public/storage/' . $path),
            storage_path('app/public/' . $path),
            public_path($path),
            public_path('storage/' . $path),
            public_path('uploads/' . $path),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        $basename = basename($path);

        foreach ([
            storage_path('app/public'),
            public_path(),
            public_path('storage'),
            public_path('uploads'),
            base_path('uploads'),
        ] as $root) {
            if (!is_dir($root)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getFilename() === $basename) {
                    return $file->getPathname();
                }
            }
        }

        return null;
    }

    private function storeFoto(Request $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }

        $directory = base_path('uploads/kerusakan');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $file = $request->file('foto');
        $filename = $file->hashName();

        $file->move($directory, $filename);

        return 'kerusakan/' . $filename;
    }

    private function deleteFoto(?string $foto): void
    {
        if (! $foto) {
            return;
        }

        foreach ([
            base_path('uploads/' . $foto),
            base_path('public/uploads/' . $foto),
            storage_path('app/public/' . $foto),
        ] as $location) {
            if (is_file($location)) {
                @unlink($location);
            }
        }
    }

    public function dashboard()
    {
        $kerusakanUser = Kerusakan::where('user_id', auth()->id());

        $total = (clone $kerusakanUser)->count();
        $totalPerJenis = collect(Kerusakan::JENIS_KERUSAKAN)
            ->mapWithKeys(fn (string $jenis) => [
                $jenis => (clone $kerusakanUser)->where('jenis_kerusakan', $jenis)->count(),
            ])
            ->all();

        $kerusakanTerbaru = (clone $kerusakanUser)
            ->withPeralatan()
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

        $foto = $this->storeFoto($request);

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
            ->where('user_id', auth()->id())
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
            $this->deleteFoto($foto);

            $foto = $this->storeFoto($request);
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
        $this->deleteFoto($kerusakan->foto);

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
