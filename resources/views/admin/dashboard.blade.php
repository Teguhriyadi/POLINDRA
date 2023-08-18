@extends("layouts.main")

@section("title", "Dashboard")

@section('content')

<div class="main" style="padding-top: 120px">
    <div class="main-content">
        <div class="container-fluid">

            @if (session("message"))
            <div class="alert alert-success">
                <strong>
                    {!! session("message") !!}
                </strong>. Anda Login Sebagai <strong>Administrator</strong>
                <hr>
                <p>
                    Silahkan Pilih Menu Untuk Memulai Program
                </p>
            </div>
            @endif

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Dashboard Admin
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-book"></i></span>
                                <p>
                                    <span class="number">{{ $izin_kegiatan }}</span>
                                    <span class="title">Izin Kegiatan</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-times"></i></span>
                                <p>
                                    <span class="number">{{ $ditolak }}</span>
                                    <span class="title">Izin Kegiatan Ditolak</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-check"></i></span>
                                <p>
                                    <span class="number">{{ $disetujui }}</span>
                                    <span class="title">Izin Kegiatan Disetujui</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                <p>
                                    <span class="number">{{ $laporan }}</span>
                                    <span class="title">Laporan Kegiatan</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-users"></i></span>
                                <p>
                                    <span class="number">{{ $pengguna }}</span>
                                    <span class="title">Data Pengguna</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
