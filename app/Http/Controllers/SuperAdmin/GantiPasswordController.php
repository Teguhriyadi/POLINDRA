<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GantiPasswordController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            return view("ormawa.ganti_password.index");
        });
    }

    public function update(Request $request, $id_user)
    {
        $messages = [
            "required" => "Kolom :attribute Harus Diisi",
            "min" => "Kolom :attribute Minimal Harus :min Digit"
        ];

        $this->validate($request, [
            "password_lama" => "required|min:8",
            "password_baru" => "required|min:8",
            "konfirmasi_password" => "required|min:8"
        ], $messages);
        
        return DB::transaction(function() use ($request, $id_user) {

            if ($request->konfirmasi_password != $request->password_baru) {
                return redirect("/super_admin/ganti_password")->with("error", "Konfirmasi Password Tidak Sesuai");
            } else {
                User::where("id", $id_user)->update([
                    "password" => bcrypt($request->password_baru)
                ]);
    
                return back()->with("success", "Password Anda Berhasil di Perbaharui");
            }
        });
    }
}
