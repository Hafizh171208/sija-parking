<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirLocation;
use App\Models\ParkirTransaction;

class ReportController extends Controller
{
    // 1. Laporan Data Gedung & Kapasitas Parkir (Tetap Aman)
    public function locationReport()
    {
        $locations = ParkirLocation::all();
        return view('report.location', compact('locations'));
    }

    // 2. Laporan Transaksi Tanpa Filter (Fungsi ini yang tadi hilang/rusak)
    public function transactionReport()
    {
        // Ambil semua data transaksi parkir dari database
        $tickets = ParkirTransaction::with(['lokasi', 'jenisKendaraan'])->orderBy('id', 'desc')->get();

        // Jumlahkan total pendapatan dari seluruh kendaraan yang sudah bayar
        $totalEarnings = $tickets->sum('total_bayar');

        // Kirim datanya ke halaman view report/transaction
        return view('report.transaction', compact('tickets', 'totalEarnings'));
    }
}