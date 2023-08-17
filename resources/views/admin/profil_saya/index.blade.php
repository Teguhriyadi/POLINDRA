@extends("layouts.main")

@section("title", "Profil Saya")

@section('content')

<div class="main">
    <div class="main-content">
        <div class="container-fluid">

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Profil Saya
                    </h3>
                </div>
                <form action="{{ url('/super_admin/profil_saya/update/'.Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <center>
                                    @if (empty(Auth::user()->foto))
                                    <img src="{{ url('/images/empty-profil.png') }}" style="width: 100px; height: 100px;">
                                    @else
                                    <input type="hidden" name="gambarOld" value="{{ Auth::user()->foto }}">
                                    <img src="{{ url('storage/'.Auth::user()->foto) }}" style="width: 10s0px; height: 100px;">
                                    @endif
                                </center>
                                <br>
                                <input type="file" class="form-control" name="foto" id="foto">
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nama" class="control-label col-md-3"> Nama </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ Auth::user()->nama }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="email" class="control-label col-md-3"> Email </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan Email" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="reset" class="btn btn-danger btn-sm">
                            BATAL
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
