<?php

namespace App\Http\Controllers\Wadir;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilSayaController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            return view("wadir.profil_saya.index");
        });
    }

    public function update(Request $request, $id_user)
    {
        return DB::transaction(function () use ($request, $id_user) {

            if (empty($request->foto)) {
                if (empty($request["gambarOld"])) {
                    $data = null;
                } else {
                    $data = $request["gambarOld"];
                }
            } else {
                if ($request->file("foto")) {
                    if ($request["gambarOld"])  {
                        Storage::delete($request["gambarOld"]);
                    }
                    $data = $request->file("foto")->store("profil_saya");
                }
            }

            User::where("id", $id_user)->update([
                "nama" => $request->nama,
                "email" => $request->email,
                "foto" => $data
            ]);

            return back();
        });
    }
}
