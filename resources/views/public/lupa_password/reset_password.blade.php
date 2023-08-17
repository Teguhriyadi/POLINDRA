<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Aplikasi Perizinan Kegiatan Ormawa - Konfirmasi Password</title>
    <link rel="icon" type="image/png" href="{{ url('/images/logo-polindra.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,body {
            font-family: 'Franklin Gothic', 'Arial Narrow', Arial, sans-serif;
            height: 100%;
        }
    </style>
</head>

<body class="my-login-page" style="background-color: #6395B9
;">
<div style="margin-top: 60px"></div>
<div class="row p-0 m-0" style="justify-content: center; align-items: center;">
    <div class="col-md-5">
        @if (session("message"))
        <div class="alert alert-danger">
            <strong>Maaf, </strong> {{ session("message") }}
        </div>
        @endif

        @if (session("success"))
        <div class="alert alert-success">
            <strong>Berhasil, </strong> {{ session("success") }}
        </div>
        @endif
        
        <div class="card">
            <form action="{{ url('/lupa_password/' . $token) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="image">
                        <center>
                            <img src="{{ url('/images/logo-polindra.png') }}" style="width: 20%; height: 20%">
                        </center>
                    </div>
                    <h4 class="text-center" style="margin-top: 20px">
                        Ganti Password
                    </h4>
                    <h6 class="text-center" style="color: gray">
                        Silahkan Isikan Form Dibawah Ini Untuk Mengganti Password Terbaru.
                    </h6>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error("password") {{ 'is-invalid' }} @enderror" name="password" id="password" placeholder="Masukkan Password">
                        @error("password")
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" class="form-control @error("confirm_password") {{ 'is-invalid' }} @enderror" name="confirm_password" id="password" placeholder="Masukkan Konfirmasi Password">
                        @error("confirm_password")
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; background-color: #00A0F0">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>