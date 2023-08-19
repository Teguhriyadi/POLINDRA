<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Models\IzinKegiatan;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class IzinKegiatanController extends Controller
{
    public function index()
    {
        return DB::transaction(function () {
            $data["izin_kegiatan"] = IzinKegiatan::where("user_id", Auth::user()->id)
            ->orderBy("created_at", "DESC")
            ->get();
            
            return view("ormawa.izin_kegiatan.index", $data);
        });
    }
    
    public function create()
    {
        $cek = IzinKegiatan::where("user_id", Auth::user()->id)->count();
        
        if ($cek == 0) {
            return view("ormawa.izin_kegiatan.create");
        } else {
            $kegiatan = IzinKegiatan::where("user_id", Auth::user()->id)->get();
            
            $isData = true; // false
            
            foreach ($kegiatan as $izin) {
                $cek_data = LaporanKegiatan::where("izin_kegiatan_id", $izin->id)->first();
                
                if (!$cek_data) {
                    $isData = false;
                    break;
                }
            }
            
            // Langsung Kesini Ketika Break;
            
            if (!$isData) {
                return back()->with("message_error", "Anda Sudah Memiliki Kegiatan");
            } else {
                return view("ormawa.izin_kegiatan.create");
            }
        }
        
    }
    
    private function checkOverlapping($tempatAwal, $tempatAkhir, $mulai, $selesai)
    {
        $overlapping = IzinKegiatan::where(function ($query) use ($tempatAwal, $tempatAkhir, $mulai, $selesai) {
            $query->where(function ($query) use ($tempatAwal, $tempatAkhir) {
                $query->where('tempat_pelaksanaan', 'LIKE', "$tempatAwal%")
                ->orWhere('tempat_pelaksanaan', 'LIKE', "%$tempatAkhir");
            })
            ->where(function ($query) use ($mulai, $selesai) {
                $query->whereBetween("mulai", [$mulai, $selesai])
                ->orWhereBetween("akhir", [$mulai, $selesai])
                ->orWhere(function ($query) use ($mulai, $selesai) {
                    $query->where("mulai", "<=", $mulai)
                    ->where("akhir", ">=", $selesai);
                });
            });
        })
        ->count();
        
        return $overlapping > 0;
    }
    
    public function store(Request $request)
    {
        $pesan = [
            'required' => "Kolom :attribute Harus Diisi",
            "mimetypes" => "Kolom :attribute Harus Berupa PDF",
            "max" => "Kolom :attribute Maximal Harus :max"
        ];
        
        $this->validate($request, [
            "nama_kegiatan" => "required",
            "mulai" => "required",
            "akhir" => "required",
            "tempat_pelaksanaan" => "required",
            "unggah_file" => "required|mimetypes:application/pdf|max:10000",
        ], $pesan);
        
        return DB::transaction(function() use ($request) {
            
            if ($request["unggah_file"]) {
                $data = $request->file("unggah_file")->store("file_laporan");
            }
            
            $tempat = $request["tempat_pelaksanaan"];
            $mulai = Carbon::parse($request["mulai"]);
            $selesai = Carbon::parse($request["akhir"]);
            
            $overlapping = IzinKegiatan::where(function ($query) use ($tempat, $mulai, $selesai) {
                $query->where(function ($query) use ($tempat) {
                    $query->where('tempat_pelaksanaan', 'LIKE', $tempat . ' %')
                    ->orWhere('tempat_pelaksanaan', 'LIKE', '% ' . $tempat);
                })
                ->where(function ($query) use ($mulai, $selesai) {
                    $query->whereBetween("mulai", [$mulai, $selesai])
                    ->orWhereBetween("akhir", [$mulai, $selesai])
                    ->orWhere(function ($query) use ($mulai, $selesai) {
                        $query->where("mulai", "<=", $mulai)
                        ->where("akhir", ">=", $selesai);
                    });
                });
            })
            ->count();
            
            if ($overlapping > 0) {
                return back()->withInput()->with("message_error", "Tanggal dan Tempat Sudah Ada Yang Mengajukan Terlebih Dahulu");
            }
            
            IzinKegiatan::create([
                "id" => Uuid::uuid4()->getHex(),
                "user_id" => Auth::user()->id,
                "nama_kegiatan" => $request["nama_kegiatan"],
                "file_laporan" => $data,
                "tempat_pelaksanaan" => $tempat,
                "mulai" => $mulai,
                "akhir" => $selesai,
                "status" => "0",
            ]);
            
            return redirect("/ormawa/izin_kegiatan")->with("message", "Data Berhasil di Tambahkan");
            
            // $cek = IzinKegiatan::count();
            
            // if ($cek == 0) {
                //     IzinKegiatan::create([
                    //         "id" => Uuid::uuid4()->getHex(),
                    //         "user_id" => Auth::user()->id,
                    //         "nama_kegiatan" => $request["nama_kegiatan"],
                    //         "tempat_pelaksanaan" => $request["tempat_pelaksanaan"],
                    //         "mulai" => $request["mulai"],
                    //         "akhir" => $request["akhir"],
                    //         "file_laporan" => $data
                    //     ]);
                    
                    //     return redirect("/ormawa/izin_kegiatan")->with("message", "Data Berhasil di Tambahkan");
                    // } else {
                        //     $mulai = Carbon::parse($request["mulai"]);
                        //     $selesai = Carbon::parse($request["akhir"]);
                        //     $tempat = $request["tempat_pelaksanaan"];
                        
                        //     $isData = true;
                        
                        //     $data_kegiatan = IzinKegiatan::get();
                        
                        //     foreach ($data_kegiatan as $item) {
                            
                            //         $tanggalMulai = Carbon::parse($item["mulai"]);
                            //         $tanggalSelesai = Carbon::parse($item["akhir"]);
                            
                            //         if (str_contains($tempat, $item["tempat_pelaksanaan"]) && $tanggalMulai->lte($selesai) && $tanggalSelesai->gte($mulai)) {
                                //             $isData = false;
                                //             break;
                                //         }
                                //     }
                                
                                //     if ($isData) {
                                    //         IzinKegiatan::create([
                                        //             "id" => Uuid::uuid4()->getHex(),
                                        //             "user_id" => Auth::user()->id,
                                        //             "nama_kegiatan" => $request["nama_kegiatan"],
                                        //             "file_laporan" => $data,
                                        //             "tempat_pelaksanaan" => $request["tempat_pelaksanaan"],
                                        //             "mulai" => $request["mulai"],
                                        //             "akhir" => $request["akhir"],
                                        //             "status" => "0",
                                        //         ]);
                                        
                                        //         return redirect("/ormawa/izin_kegiatan")->with("message", "Data Berhasil di Tambahkan");
                                        //     } else {
                                            //         return back()->withInput()->with("message_error", "Tanggal dan Tempat Sudah Ada Yang Mengajukan Terlebih Dahulu");
                                            //     }
                                            // }
                                        });
                                    }
                                    
                                    public function edit($id)
                                    {
                                        return DB::transaction(function() use ($id) {
                                            $data["edit"] = IzinKegiatan::where("id", $id)->first();
                                            
                                            return view("ormawa.izin_kegiatan.edit", $data);
                                        });
                                    }
                                    
                                    public function update(Request $request, $id)
                                    {
                                        $pesan = [
                                            'required' => "Kolom :attribute Harus Diisi",
                                            "mimetypes" => "Kolom :attribute Harus Berupa PDF",
                                            "max" => "Kolom :attribute Maximal Harus :max"
                                        ];
                                        
                                        $this->validate($request, [
                                            "nama_kegiatan" => "required",
                                            "mulai" => "required",
                                            "akhir" => "required",
                                            "tempat_pelaksanaan" => "required",
                                            "unggah_file" => "mimetypes:application/pdf|max:10000"
                                        ], $pesan);
                                        
                                        return DB::transaction(function() use ($request, $id) {
                                            
                                            if ($request->file("unggah_file")) {
                                                if ($request->file_lama) {
                                                    Storage::delete($request->file_lama);
                                                }
                                                
                                                $data = $request->file("unggah_file")->store("file_laporan");
                                                
                                            } else {
                                                $data = $request->file_lama;
                                            }
                                            
                                            IzinKegiatan::where("id", $id)->update([
                                                "nama_kegiatan" => $request["nama_kegiatan"],
                                                "tempat_pelaksanaan" => $request["tempat_pelaksanaan"],
                                                "mulai" => $request["mulai"],
                                                "akhir" => $request["akhir"],
                                                "file_laporan" => $data
                                            ]);
                                            
                                            return redirect("/ormawa/izin_kegiatan")->with("message", "Data Berhasil di Simpan");
                                        });
                                    }
                                    
                                    public function destroy($id)
                                    {
                                        return DB::transaction(function() use ($id) {
                                            $izin_kegiatan = IzinKegiatan::where("id", $id)->first();
                                            
                                            Storage::delete($izin_kegiatan->file_laporan);
                                            
                                            $izin_kegiatan->delete();
                                            
                                            return back()->with("message", "Data Berhasil di Hapus");
                                        });
                                    }
                                    
                                    public function show($id)
                                    {
                                        return DB::transaction(function() use ($id) {
                                            $data["detail"] = IzinKegiatan::where("id", $id)->first();
                                            
                                            return view("ormawa.izin_kegiatan.detail", $data);
                                        });
                                    }
                                    
                                    public function ulang($id)
                                    {
                                        return DB::transaction(function () use ($id) {
                                            $data["detail"] = IzinKegiatan::where("id", $id)->first();
                                            
                                            return view("ormawa.izin_kegiatan.ulang", $data);
                                        });
                                    }
                                    
                                    public function ajukan(Request $request, $id)
                                    {
                                        return DB::transaction(function() use ($request, $id) {
                                            
                                            $pesan = [
                                                'required' => "Kolom :attribute Harus Diisi"
                                            ];
                                            
                                            $this->validate($request, [
                                                "nama_kegiatan" => "required",
                                                "mulai" => "required",
                                                "akhir" => "required",
                                                "tempat_pelaksanaan" => "required"
                                            ], $pesan);
                                            
                                            return DB::transaction(function() use ($request, $id) {
                                                
                                                if ($request->file("unggah_file")) {
                                                    if ($request->file_lama) {
                                                        Storage::delete($request->file_lama);
                                                    }
                                                    
                                                    $data = $request->file("unggah_file")->store("file_laporan");
                                                    
                                                } else {
                                                    $data = $request->file_lama;
                                                }
                                                
                                                IzinKegiatan::where("id", $id)->update([
                                                    "nama_kegiatan" => $request["nama_kegiatan"],
                                                    "tempat_pelaksanaan" => $request["tempat_pelaksanaan"],
                                                    "mulai" => $request["mulai"],
                                                    "akhir" => $request["akhir"],
                                                    "file_laporan" => $data,
                                                    "status" => "3"
                                                ]);
                                                
                                                return redirect("/ormawa/izin_kegiatan")->with("message", "Data Berhasil di Simpan");
                                            });
                                            
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
                                