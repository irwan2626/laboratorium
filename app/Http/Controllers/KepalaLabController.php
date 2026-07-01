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
        $kerusakanQuery = $this->filteredKerusakan($request);
        $kerusakan = $kerusakanQuery->latest()->get();

        $grafikBulanan = Kerusakan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return view('kepala_lab.dashboard', [
            'totalLaboratorium' => count($lokasiLab),
            'totalKerusakan' => Kerusakan::count(),
            'totalAlatDigunakan' => Peralatan::where('kondisi', 'Digunakan')->count(),
            'grafikBulanan' => $grafikBulanan,
            'grafikPerLabor' => Kerusakan::countByLaboratorium($lokasiLab),
            'totalPerKategori' => Kerusakan::countByJenis(),
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

        return Kerusakan::withReportRelations()
            ->filterLaporan($filter);
    }
}
