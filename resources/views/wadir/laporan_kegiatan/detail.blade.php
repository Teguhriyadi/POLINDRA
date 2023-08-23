@php
    use Carbon\Carbon;
@endphp

@extends("layouts.main")

@section("title", "Detail Laporan Kegiatan")

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            <a href="{{ url('/wadir/laporan_kegiatan') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out"></i> KEMBALI 
            </a>

            <br><br>

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Detail Laporan Kegiatan
                    </h3>
                </div>
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
                                <a target="_blank" href="{{ url('/wadir/laporan_kegiatan/izin/'.$detail["id"].'/file') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-download"></i> UNDUH FILE
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="file_lpj" class="control-label col-md-3"> File LPJ </label>
                            <div class="col-md-7">
                                @if (empty($detail["laporan_kegiatan"]["id"]))
                                    <strong>
                                        <i>
                                            Belum Upload File LPJ
                                        </i>
                                    </strong>
                                @else
                                <a target="_blank" href="{{ url('/wadir/laporan_kegiatan/lpj/'.$detail["laporan_kegiatan"]["id"]) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-download"></i> UNDUH FILE
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="foto_dokumentasi" class="control-label col-md-3"> Foto Dokumentasi </label>
                            <div class="col-md-7">
                                @if (empty($detail["laporan_kegiatan"]["foto_dokumentasi"]))
                                    <strong>
                                        <i>
                                            Belum Upload Foto Dokumentasi    
                                        </i>    
                                    </strong>    
                                @else
                                    <img src="{{ url('storage/'.$detail["laporan_kegiatan"]["foto_dokumentasi"]) }}" style="width: 50px; height: 50px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
