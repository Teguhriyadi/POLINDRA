@php
use Carbon\Carbon;
@endphp

@extends("layouts.main")

@section("title", "Detail Laporan Kegiatan")

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">
            
            <a href="{{ url('/ormawa/laporan_kegiatan') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out"></i> KEMBALI 
            </a>
            
            <br><br>
            
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Detail Laporan Kegiatan
                    </h3>
                </div>
                <form action="{{ url('/ormawa/laporan_kegiatan/update/'.$detail["id"]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama_kegiatan" class="control-label col-md-3"> Nama Kegiatan </label>
                                <div class="col-md-7">
                                    {{ $detail['nama_kegiatan'] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="waktu_pelaksanaan" class="control-label col-md-3"> Waktu Pelaksanaan </label>
                                <div class="col-md-7">
                                    @php
                                    $mulai = Carbon::createFromFormat('Y-m-d H:i:s', $detail->mulai);
                                    $format = $mulai->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                                    echo $format;
                                    @endphp
                                    s/d
                                    @php
                                    $akhir = Carbon::createFromFormat('Y-m-d H:i:s', $detail->akhir);
                                    $format = $akhir->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                                    echo $format;
                                    @endphp
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="tempat_pelaksanaan" class="control-label col-md-3"> Tempat Pelaksanaan </label>
                                <div class="col-md-7">
                                    {{ $detail["tempat_pelaksanaan"] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="unggah_file" class="control-label col-md-3"> File Izin Kegiatan </label>
                                <div class="col-md-7">
                                    <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/izin/'.$detail["id"].'/file') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-download"></i> UNDUH FILE
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-3"> Tanggal Pengajuan Kegiatan </label>
                                <div class="col-md-7">
                                    @php
                                    $akhir = Carbon::createFromFormat('Y-m-d H:i:s', $detail->created_at);
                                    $format = $akhir->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                                    echo $format;
                                    @endphp
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3"> File Surat Balasan </label>
                                <div class="col-md-7">
                                    <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/balasan/'.$detail["id"]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-download"></i> Unduh File
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3"> Foto Dokumentasi </label>
                                <div class="col-md-7">
                                    <img src="{{ url('/storage/'.$detail->laporan_kegiatan->foto_dokumentasi) }}" class="img-responsive" style="width: 100px; height: 100px">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
