<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index() {
        $layanan = Layanan::all();

        return response()->json([
            'status' => 'success',
            'data' => $layanan,
        ]);
    }
}
