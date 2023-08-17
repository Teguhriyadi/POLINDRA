<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\IzinKegiatan;
use App\Models\LaporanKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKegiatanController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            $data["laporan"] = IzinKegiatan::get();

            return view("admin.laporan_kegiatan.index", $data);
        });
    }

    public function show($id)
    {
        return DB::transaction(function() use ($id) {
            $data["detail"] = IzinKegiatan::where("id", $id)->first();

            return view("admin.laporan_kegiatan.detail", $data);
        });
    }

    public function lpj($id)
    {
        return DB::transaction(function() use ($id) {
            $laporan_kegiatan = LaporanKegiatan::where("id", $id)->first();
            
            return response()->download("storage/".$laporan_kegiatan->file_lpj);
        });
    }
}
