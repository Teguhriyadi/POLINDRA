<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;

class LupaPasswordController extends Controller
{
    public function index()
    {
        return DB::transaction(function() {
            return view("public.lupa_password.index");
        });
    }

    public function store(Request $request)
    {   
        $messages = [
            "required" => "Kolom :attribute Tidak Boleh Kosong",
            "email" => "Inputan Harus Email" 
        ];

        $this->validate($request, [
            "email" => "required|email"
        ], $messages);

        return DB::transaction(function() use ($request) {
            $user = User::where("email", $request->email)->first();

            if (!$user) {
                return back()->with("message", "Email Tidak Ditemukan")->withInput();
            }

            $last_id = $user->id;

            $token = $last_id . hash('sha256', Str::random(120));
            
            ResetPassword::create([
                "id" => Uuid::uuid4()->getHex(),
                "user_id" => $user["id"],
                "token" => $token,
                "status" => "0"
            ]);

            $verifyUrl = url("/", ["token" => $token, "service" => "reset_password"]);

            $pesan = "Selamat Datang <b>" . $user["nama"] . "</b><br> di <b>Aplikasi Perizinan Kegiatan Ormawa</b>";
            $pesan .= "<hr>";
            $pesan .= "Silahkan Klik Tombol Dibawah Ini Jika Anda Ingin Mengganti Password <br>";
            $pesan .= "Terima Kasih...";
            $mail_data = [
                'recipient' => $user['email'],
                'fromEmail' => $user['email'],
                'fromName' => $user['nama'],
                'subject' => 'Lupa Password',
                'body' => $pesan,
                'actionLink' => $verifyUrl
            ];

            Mail::send('public/lupa_password/konfirmasi', $mail_data, function ($message) use ($mail_data) {
                $message->to($mail_data['recipient'])
                    ->from($mail_data['fromEmail'], $mail_data['fromName'])
                    ->subject($mail_data['subject']);
            });

            return back()->with("success", "Permintaan Berhasil di Kirim ke Email");

        });
    }

    public function update(Request $request, $token)
    {
        $messages = [
            "required" => "Kolom :attribute Tidak Boleh Kosong",
            "min" => "Kolom :min Minimal Harus :min Digit",
            "max" => "Kolom :max Minimal Harus :max Digit"
        ];

        $this->validate($request, [
            "password" => "required|min:8|max:15",
            "confirm_password" => "required|min:8|max:15"
        ], $messages);       

        return DB::transaction(function() use ($request, $token) {

            if ($request->password != $request->confirm_password) {
                return back()->with("message", "Konfirmasi Password Tidak Sesuai");
            }

            $token = ResetPassword::where("token", $token)->first();

            if (!$token) {
                return back()->with("message", "Token Tidak Valid");
            }

            if ($token->status == "1") {
                return back()->with("message", "Token Sudah Digunakan");
            }

            User::where("id", $token->user_id)->update([
                "password" => bcrypt($request->password)
            ]);

            $token->update([
                "status" => "1"
            ]);

            return redirect("/login")->with("success", "Password Berhasil di Perbaharui. Silahkan Login.");
            
        });
    }

    public function konfirmasi($token)
    {
        return DB::transaction(function () use ($token) {
            return view("public.lupa_password.reset_password", compact("token"));
        });
    }
}
