<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PenggunaController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            $data["user"] = User::orderBy("created_at", "DESC")->get();

            return view("admin.pengguna.index", $data);
        });
    }

    public function create()
    {
        return view("admin.pengguna.create");
    }

    public function store(Request $request)
    {
        $messages = [
            "required" => "Kolom :attribute Harus Diisi",
            "email" => "Kolom :attribute Harus Berbentuk Inputan Email"
        ];

        $this->validate($request, [
            "nama" => "required",
            "email" => "required|email",
            "role" => "required"
        ], $messages);

        return DB::transaction(function() use ($request) {

            $cek = User::where("email", $request->email)->count();

            if ($cek > 0) {
                return back()->with("message_error", "Email Sudah Digunakan")->withInput();
            }

            if ($request["role"] == "ormawa") {
                $role = "ormawa123";
            } else if ($request["role"] == "wadir") {
                $role = "wadir123";
            } else if ($request["role"] == "admin") {
                $role = "admin123";
            }

            User::create([
                "id" => Uuid::uuid4()->getHex(),
                "nama" => $request["nama"],
                "email" => $request["email"],
                "password" => bcrypt($role),
                "created_by" => Auth::user()->id,
                "role" => $request["role"],
                "deskripsi" => empty($request["deskripsi"]) ? null : $request["deskripsi"]
            ]);

            return redirect("/super_admin/pengguna")->with("message", "Data Berhasil di Tambahkan");
        });
    }

    public function edit($id)
    {
        return DB::transaction(function() use ($id) {
            $data["edit"] = User::where("id", $id)->first();

            return view("admin.pengguna.edit", $data);
        });
    }

    public function update(Request $request, $id)
    {
        $messages = [
            "required" => "Kolom :attribute Harus Diisi",
            "email" => "Kolom :attribute Harus Berbentuk Inputan Email"
        ];

        $this->validate($request, [
            "nama" => "required",
            "email" => "required|email",
            "role" => "required"
        ], $messages);

        return DB::transaction(function() use ($request, $id) {

            $cek = User::where("email", $request->email)->count();

            if ($cek > 0) {
                return back()->with("message_error", "Email Sudah Digunakan")->withInput();
            }

            if ($request["role"] == "ormawa") {
                $role = "ormawa123";
            } else if ($request["role"] == "wadir") {
                $role = "wadir123";
            } else if ($request["role"] == "admin") {
                $role = "admin123";
            }

            User::where("id", $id)->update([
                "nama" => $request->nama,
                "password" => bcrypt($role),
                "role" => $request->role,
                "deskripsi" => empty($request["deskripsi"]) ? null : $request["deskripsi"]
            ]);

            return redirect("/super_admin/pengguna")->with("message", "Data Berhasil di Simpan");
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function() use ($id) {
            User::where("id", $id)->delete();

            return back();
        });
    }

    public function aktifkan($id)
    {
        return DB::transaction(function() use ($id) {
            User::where("id", $id)->update([
                "status" => "1"
            ]);

            return back();
        });
    }

    public function non_aktifkan($id)
    {
        return DB::transaction(function() use ($id) {
            User::where("id", $id)->update([
                "status" => "0"
            ]);

            return back();
        });
    }
}
