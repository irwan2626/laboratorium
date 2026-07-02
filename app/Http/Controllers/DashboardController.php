<?php

namespace App\Http\Controllers;

use App\Models\KategoriKerusakan;
use App\Models\Kerusakan;
use App\Models\Peralatan;
use App\Models\User;

class DashboardController extends Controller
{
    public function redirectByRole()
    {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'asisten' => redirect()->route('asisten.dashboard'),
            'kepala_lab' => redirect()->route('kepala_lab.dashboard'),
            default => abort(403),
        };
    }

    public function admin()
    {
        $peralatan = Peralatan::whereHas('kerusakan')->latest()->get();
        $kerusakan = Kerusakan::withPeralatan()
            ->whereHas('peralatan', fn ($query) => $query->whereIn('kondisi', ['Rusak', 'Tidak Bisa Digunakan']))
            ->latest()
            ->get();

        $grafikKerusakan = collect(Kerusakan::JENIS_KERUSAKAN)
            ->mapWithKeys(fn (string $jenis) => [
                $jenis => $kerusakan->where('jenis_kerusakan', $jenis)->count(),
            ])
            ->all();

        return view('admin.dashboard', [
            'totalLaboratorium' => count(User::LOKASI_LAB),
            'totalPeralatan' => $peralatan->count(),
            'totalKerusakan' => $kerusakan->count(),
            'totalAlatDigunakan' => $peralatan->where('kondisi', 'Digunakan')->count(),
            'grafikKerusakan' => $grafikKerusakan,
            'peralatan' => $peralatan,
            'kerusakan' => $kerusakan,
            'kategoriKerusakan' => KategoriKerusakan::latest()->get(),
            'users' => User::latest()->get(),
        ]);
    }
}
