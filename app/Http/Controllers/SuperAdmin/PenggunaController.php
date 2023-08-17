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
        return DB::transaction(function() use ($request) {
            User::create([
                "id" => Uuid::uuid4()->getHex(),
                "nama" => $request["nama"],
                "email" => $request["email"],
                "password" => bcrypt("administrator123"),
                "created_by" => Auth::user()->id,
                "role" => $request["role"],
                "deskripsi" => $request["deskripsi"]
            ]);

            return redirect("/super_admin/pengguna");
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
        return DB::transaction(function() use ($request, $id) {
            User::where("id", $id)->update([
                "nama" => $request->nama,
                "role" => $request->role,
                "deskripsi" => $request->deskripsi 
            ]);

            return redirect("/super_admin/pengguna");
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
