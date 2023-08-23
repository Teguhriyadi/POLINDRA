<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Models\IzinKegiatan;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Termwind\Components\Raw;
use PDF;

class LaporanKegiatanController extends Controller
{
    public function index()
    {
        return DB::transaction(function () {
            
            $bulan = date("M");
            $carbonBulan = Carbon::createFromFormat('M', $bulan);
            $bulan = $carbonBulan->format('m');
            
            $data["tahun"] = date("Y");
            
            $data["laporan"] = IzinKegiatan::where("user_id", Auth::user()->id)
            ->where("file_surat_balasan", "!=", null)
            ->orderBy("created_at", "ASC")
            ->get();
            
            $tahunAwal = LaporanKegiatan::orderBy('created_at', 'asc')->value('created_at');
            $tahunAwal = Carbon::parse($tahunAwal)->year;
            $data["tahun_range"] = range($tahunAwal, $data["tahun"]);
            
            $data["c_bulan"] = Carbon::createFromDate(null, $bulan, null)->translatedFormat('F');
            
            return view("ormawa.laporan_kegiatan.index", $data);
        });
    }

    public function post(Request $request)
    {
        return DB::transaction(function() use ($request) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            
            $laporan_kegiatan = LaporanKegiatan::whereMonth("created_at", $request->bulan)
            ->whereYear("created_at", $request->tahun)
            ->where("user_id", Auth::user()->id)
            ->orderBy("created_at", "ASC")
            ->get();

            $tahunSekarang = date('Y');
            $tahunAwal = LaporanKegiatan::orderBy('created_at', 'asc')->value('created_at');
            $tahunAwal = Carbon::parse($tahunAwal)->year;
            $tahun_range = range($tahunAwal, $tahunSekarang);
            
            $c_bulan = Carbon::createFromDate(null, $bulan, null)->translatedFormat('F');
            
            return back()->with(["laporan" => $laporan_kegiatan, "tahun_range" => $tahun_range, "tahun" => $tahun, "bulan" => $bulan, "message" => "Filter Data Laporan Kegiatan Bulan <strong>" . $c_bulan . "</strong> Tahun " . "<strong>" . $request->tahun ."</strong> Berhasil di Lakukan"]);
        });
    }
    
    public function create($id)
    {
        return DB::transaction(function() use ($id) {
            $data["detail"] = IzinKegiatan::where("id", $id)->first();
            
            return view("ormawa.laporan_kegiatan.create", $data);
        });
    }
    
    public function store(Request $request, $id)
    {
        $messages = [
            "required" => "Kolom :attribute Harus Diisi",
            "image" => "Kolom :attribute Harus Berupa Gambar",
            "mimes" => "Kolom :attribute Harus PNG, JPG, JPEG",
            "mimestypes" => "Kolom :attribute Harus PDF",
            "max" => "Kolom :attribute Tidak Boleh Lebih Dari :max"
        ];
        
        $this->validate($request, [
            "file_lpj" => "required|mimetypes:application/pdf|max:10000",
            "foto_dokumentasi" => "required|image|mimes:png,jpg,jpeg|max:204"
        ], $messages);
        
        return DB::transaction(function() use ($request, $id) {
            
            $lpj = $request->file("file_lpj")->store("lpj");
            $dokumentasi = $request->file("foto_dokumentasi")->store("dokumentasi");
            
            LaporanKegiatan::create([
                "id" => Uuid::uuid4()->getHex(),
                "user_id" => Auth::user()->id,
                "izin_kegiatan_id" => $id,
                "file_lpj" => $lpj,
                "foto_dokumentasi" => $dokumentasi
            ]);
            
            return redirect("/ormawa/laporan_kegiatan")->with("message", "Data Berhasil di Tambahkan");
        });
    }
    
    public function show($id)
    {
        return DB::transaction(function() use ($id) {
            $data["detail"] = IzinKegiatan::where("id", $id)->first();
            
            return view("ormawa.laporan_kegiatan.detail", $data);
        });
    }
    
    public function update(Request $request, $id)
    {
        $pesan = [
            "required" => "Kolom :attribute Harus Diisi"
        ];
        
        $this->validate($request, [
            "file_lpj" => "required",
            "foto_dokumentasi" => "required"
        ], $pesan);
        
        return DB::transaction(function() use ($id, $request) {
            
            if ($request->file("file_lpj")) {
                $file_lpj = $request->file("file_lpj")->store("file_lpj");
            }
            
            if ($request->file("foto_dokumentasi")) {
                $foto_dokumentasi = $request->file("foto_dokumentasi")->store("foto_dokumentasi");
            }
            
            LaporanKegiatan::create([
                "id" => Uuid::uuid4()->getHex(),
                "user_id" => Auth::user()->id,
                "izin_kegiatan_id" => $id,
                "file_lpj" => $file_lpj,
                "foto_dokumentasi" => $foto_dokumentasi
            ]);
            
            return redirect("/ormawa/laporan_kegiatan")->with("message", "Data Berhasil di Simpan");
        });
    }
    
    public function laporan($id_laporan)
    {
        return DB::transaction(function() use ($id_laporan) {
            $laporan_kegiatan = LaporanKegiatan::where("id", $id_laporan)->first();
            
            return response()->download("storage/".$laporan_kegiatan["file_lpj"]);
        });
    }
    
    public function lpj($id)
    {
        return DB::transaction(function() use ($id) {
            $laporan_kegiatan = LaporanKegiatan::where("id", $id)->first();
            
            return response()->download("storage/".$laporan_kegiatan->file_lpj);
        });
    }
    
    public function balasan($id)
    {
        return DB::transaction(function() use ($id) {
            $kegiatan = IzinKegiatan::where("id", $id)->first();
            
            return response()->download("storage/".$kegiatan["file_surat_balasan"]);
        });
    }

    public function filter($bulan, $tahun)
    {
        return DB::transaction(function() use ($bulan, $tahun) {
            $laporan = LaporanKegiatan::whereMonth("created_at", $bulan)
            ->whereYear("created_at", $tahun)
            ->where("user_id", Auth::user()->id)
            ->orderBy("created_at", "ASC")
            ->get(); 
            
            $c_bulan = Carbon::createFromDate(null, $bulan, null)->translatedFormat('F');
            $c_tahun = $tahun;
            
            $pdf = PDF::loadView("ormawa.laporan_kegiatan.filter", ["laporan" => $laporan, "bulan" => $c_bulan, "tahun" => $c_tahun])->setPaper("a3");
            
            return $pdf->download("Data_Laporan_Kegiatan_Bulan_" . $c_bulan . "_Tahun_" . $c_tahun . ".pdf");
        });
    }

    public function izin($id_kegiatan)
    {
        return DB::transaction(function() use ($id_kegiatan) {
            $kegiatan = IzinKegiatan::where("id", $id_kegiatan)->first();
            
            return response()->download("storage/".$kegiatan["file_laporan"]);
        });
    }
}
