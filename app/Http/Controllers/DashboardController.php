<?php

namespace App\Http\Controllers;

use App\Models\KategoriKerusakan;
use App\Models\Kerusakan;
use App\Models\Laboratorium;
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
        $grafikKerusakan = collect(Kerusakan::JENIS_KERUSAKAN)
            ->mapWithKeys(fn (string $jenis) => [
                $jenis => Kerusakan::where('jenis_kerusakan', $jenis)->count(),
            ])
            ->all();

        return view('admin.dashboard', [
            'totalLaboratorium' => Laboratorium::count(),
            'totalPeralatan' => Peralatan::count(),
            'totalKerusakan' => Kerusakan::count(),
            'totalAlatDigunakan' => Peralatan::whereIn('kondisi', ['Digunakan', 'Sedang Digunakan'])->count(),
            'grafikKerusakan' => $grafikKerusakan,
            'peralatan' => Peralatan::latest()->get(),
            'kerusakan' => Kerusakan::withPeralatan()->latest()->get(),
            'kategoriKerusakan' => KategoriKerusakan::latest()->get(),
            'users' => User::latest()->get(),
        ]);
    }
}
