@extends("layouts.main")

@section("title", "Edit Data Pengguna")

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            @if (session("message_error"))
            <div class="alert alert-danger">
                <strong>Maaf, </strong>
                {!! session("message_error") !!}
            </div>
            @endif
            
            <a href="{{ url('/super_admin/pengguna') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out"></i> KEMBALI
            </a>
            
            <br><br>
            
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Edit Data Pengguna
                    </h3>
                </div>
                <form action="{{ url('/super_admin/pengguna/update/'.$edit["id"]) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="panel-body">
                        <div class="form-group @error("nama") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="nama" class="control-label col-md-3"> Nama </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ old('nama') ?? $edit["nama"] ?? '' }}">
                                    @error("nama")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group @error("email") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="email" class="control-label col-md-3"> Email </label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') ?? $edit["email"] ?? '' }}" readonly>
                                    @error("email")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group @error("role") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="role" class="control-label col-md-3"> Peran Akun </label>
                                <div class="col-md-7">
                                    <select name="role" class="form-control" id="role">
                                        <option value="">- Silahkan Pilih -</option>
                                        <option value="admin" {{ old('role') || $edit["role"] == "admin" ? 'selected' : '' }} >Admin</option>
                                        <option value="wadir" {{ old('role') || $edit["role"] == "wadir" ? 'selected' : '' }} >Wadir</option>
                                        <option value="ormawa" {{ old('role') || $edit["role"] == "ormawa" ? 'selected' : '' }} >Ormawa</option>
                                    </select>
                                    @error("role")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <label for="deskripsi" class="control-label col-md-3"> Deskripsi </label>
                                <div class="col-md-7">
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" rows="5" placeholder="Masukkan Deskripsi">{{ old('deskripsi') ?? $edit["deskripsi"] ?? '' }}</textarea>
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
