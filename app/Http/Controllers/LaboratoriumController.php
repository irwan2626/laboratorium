<?php

namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasiLaboratorium = User::LOKASI_LAB;
        $kerusakanPerLaboratorium = Kerusakan::with(['peralatan', 'user'])
            ->latest()
            ->get()
            ->groupBy(fn (Kerusakan $kerusakan) => $kerusakan->user->lokasi_lab ?? 'Tanpa Laboratorium');
        $lokasiLaboratorium = collect($lokasiLaboratorium)
            ->when($kerusakanPerLaboratorium->has('Tanpa Laboratorium'), fn ($lokasi) => $lokasi->push('Tanpa Laboratorium'))
            ->all();

        return view('admin.laboratorium.index', compact('lokasiLaboratorium', 'kerusakanPerLaboratorium'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratorium $laboratorium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratorium $laboratorium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laboratorium $laboratorium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratorium $laboratorium)
    {
        //
    }
}
