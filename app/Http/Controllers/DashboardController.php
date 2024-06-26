<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\penjualan;
use App\Models\produk;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saldoProduk = produk::where('nama_produk', 'saldo')->first();
        $saldoStok = $saldoProduk ? $saldoProduk->stok : 0;

        $today = Carbon::today();
        $totalSales = penjualan::whereDate('tanggal', $today)->count();

        return view('dashboard', compact('totalSales', 'saldoStok'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
