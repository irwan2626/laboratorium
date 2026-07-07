<?php

namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Peralatan;
use App\Models\User;
use Illuminate\Http\Request;

class KepalaLabController extends Controller
{
    public function dashboard(Request $request)
    {
        return $this->renderDashboard($request, false);
    }

    public function laporan(Request $request)
    {
        return $this->renderDashboard($request, true);
    }

    private function renderDashboard(Request $request, bool $reportOnly)
    {
        $lokasiLab = User::LOKASI_LAB;
        $kerusakan = $this->filteredKerusakan($request)->latest()->get();
        $semuaKerusakan = $this->validKerusakanQuery()->get();

        $grafikBulanan = $semuaKerusakan
            ->groupBy(fn (Kerusakan $data) => (int) date('n', strtotime($data->tanggal)))
            ->map(fn ($items) => $items->count());

        $grafikPerLabor = collect($lokasiLab)
            ->mapWithKeys(fn (string $laboratorium) => [
                $laboratorium => $semuaKerusakan
                    ->filter(fn (Kerusakan $data) => ($data->user->lokasi_lab ?? null) === $laboratorium)
                    ->count(),
            ])
            ->all();

        $totalPerKategori = collect(Kerusakan::JENIS_KERUSAKAN)
            ->mapWithKeys(fn (string $jenis) => [
                $jenis => $semuaKerusakan->where('jenis_kerusakan', $jenis)->count(),
            ])
            ->all();

        return view('kepala_lab.dashboard', [
            'totalLaboratorium' => count($lokasiLab),
            'totalKerusakan' => $semuaKerusakan->count(),
            'totalAlatDigunakan' => Peralatan::whereHas('kerusakan')
                ->where('kondisi', 'Digunakan')
                ->count(),
            'grafikBulanan' => $grafikBulanan,
            'grafikPerLabor' => $grafikPerLabor,
            'totalPerKategori' => $totalPerKategori,
            'kerusakan' => $kerusakan,
            'lokasiLab' => $lokasiLab,
            'filter' => $request->only(['tanggal_mulai', 'tanggal_selesai', 'laboratorium', 'status', 'kategori']),
            'reportOnly' => $reportOnly,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $kerusakan = $this->filteredKerusakan($request)->latest()->get();
        $filename = 'laporan-kerusakan-'.now()->format('Ymd-His').'.xls';

        $content = view('kepala_lab.exports.excel', compact('kerusakan'))->render();

        return response($content)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function exportPdf(Request $request)
    {
        $kerusakan = $this->filteredKerusakan($request)->latest()->get();

        return view('kepala_lab.exports.pdf', compact('kerusakan'));
    }

    private function filteredKerusakan(Request $request)
    {
        $filter = collect($request->only(['tanggal_mulai', 'tanggal_selesai', 'laboratorium', 'status', 'kategori']))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->filter(fn ($value) => filled($value))
            ->all();

        return $this->activeKerusakanQuery()
            ->filterLaporan($filter);
    }

    private function activeKerusakanQuery()
    {
        return Kerusakan::withReportRelations()
            ->whereHas('peralatan');
    }

    private function validKerusakanQuery()
    {
        return $this->activeKerusakanQuery()
            ->whereHas('peralatan', fn ($query) => $query->whereIn('kondisi', ['Rusak', 'Tidak Bisa Digunakan']));
    }
}
