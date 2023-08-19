@extends("layouts.main")

@section("title", "Ganti Password")

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">
            
            @if (session("success"))
            <div class="alert alert-success">
                {!! session("success") !!}
            </div>
            @endif

            @if (session("error"))
            <div class="alert alert-danger">
                {!! session("error") !!}
            </div>
            @endif

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Ganti Password
                    </h3>
                </div>
                <form action="{{ url('/wadir/ganti_password/update/'.Auth::user()->id) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="panel-body">
                        <div class="form-group @error("password_lama") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="password_lama" class="control-label col-md-3"> Password Lama </label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password_lama" id="password_lama" placeholder="Masukkan Password Lama">
                                    @error("password_lama")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error("password_baru") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="password_baru" class="control-label col-md-3"> Password Baru </label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Masukkan Password Baru">
                                    @error("password_baru")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error("konfirmasi_password") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="konfirmasi_password" class="control-label col-md-3"> Konfirmasi Password </label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Masukkan Konfirmasi Password">
                                    @error("konfirmasi_password")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> BATAL
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-save"></i> SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
