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
        $lokasiLaboratorium = collect(User::LOKASI_LAB)->all();

        $kerusakanPerLaboratorium = collect($lokasiLaboratorium)
            ->mapWithKeys(function (string $laboratorium) {
                $kerusakan = Kerusakan::withPeralatan()
                    ->whereHas('user', fn ($query) => $query->where('lokasi_lab', $laboratorium))
                    ->latest()
                    ->get();

                return [$laboratorium => $kerusakan];
            });

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
