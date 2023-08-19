<?php

namespace App\Http\Controllers\Wadir;

use App\Http\Controllers\Controller;
use App\Models\IzinKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinKegiatanController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            $data["izin_kegiatan"] = IzinKegiatan::orderBy("status", "ASC")->orderBy("created_at", "ASC")->get();

            return view("wadir.izin_kegiatan.index", $data);
        });
    }

    public function show($id)
    {
        return DB::transaction(function() use ($id) {
            $data["detail"] = IzinKegiatan::where("id", $id)->first();

            return view("wadir.izin_kegiatan.detail", $data);
        });
    }

    public function update(Request $request, $id)
    {
        $pesan = [
            "required" => "Kolom :attribute Harus Diisi"    
        ];

        $this->validate($request, [
            "status" => "required"
        ], $pesan);

        return DB::transaction(function() use ($request, $id) {

            if ($request->komentar) {
                $komentar = $request->komentar;
            } else {
                $komentar = null;
            }

            $count = false;
            $ormawa = null;

            $data_kegiatan = IzinKegiatan::where("id", $id)->first();

            if ($request->status == 1) {
                $izin = IzinKegiatan::where("status", 1)->get();

                foreach ($izin as $i) {
                    if ($i->tempat_pelaksanaan == $data_kegiatan->tempat_pelaksanaan) {
                        $count = true;
                        $ormawa = $i->users->nama;
                        break;
                    }
                }
            }

            if ($count) {
                return back()->withInput()->with("message_error", "Tanggal / Waktu dan Tempat Sudah Disii Oleh Ormawa <strong>".$ormawa."</strong> ");
            }
            
            IzinKegiatan::where("id", $id)->update([
                "status" => $request["status"],
                "user_validasi_id" => Auth::user()->id,
                "komentar" => $komentar
            ]);

            return redirect("/wadir/izin_kegiatan")->with("message", "Data Berhasil di Konfirmasi");
        });
    }

    public function laporan($id)
    {
        return DB::transaction(function() use ($id) {
            $data = IzinKegiatan::where("id", $id)->first();

            return response()->download("storage/".$data["file_laporan"]);
        });
    }

    public function balasan($id)
    {
        return DB::transaction(function() use ($id) {
            $data = IzinKegiatan::where("id", $id)->first();

            return response()->download("storage/".$data["file_surat_balasan"]);
        });
    }
}
