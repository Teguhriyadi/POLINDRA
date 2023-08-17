@php
    use Carbon\Carbon;
@endphp

@extends("layouts.main")

@section("title", "Detail Laporan Kegiatan")

@section('content')

<div class="main">
    <div class="main-content">
        <div class="container-fluid">

            <a href="{{ url('/ormawa/laporan_kegiatan') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out"></i> KEMBALI 
            </a>

            <br><br>

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Unggah Laporan Kegiatan
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
                                    <a href="" class="btn btn-primary btn-sm">
                                        <i class="fa fa-download"></i> UNDUH FILE
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error("file_lpj") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="file_lpj" class="control-label col-md-3"> Unggah File LPJ </label>
                                <div class="col-md-7">
                                    @if (!empty($detail->laporan_kegiatan))
                                    <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/lpj/'.$detail["laporan_kegiatan"]["id"]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-download"></i> UNDUH FILE
                                    </a>
                                    @else
                                    <input type="file" class="form-control" name="file_lpj" id="file_lpj">
                                    @error("file_lpj")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error("foto_dokumentasi") {{ 'has-error' }} @enderror">
                            <div class="row">
                                <label for="foto_dokumentasi" class="control-label col-md-3"> Foto Dokumentasi </label>
                                <div class="col-md-7">
                                    @if (!empty($detail->laporan_kegiatan))
                                    <img src="{{ url('/storage/'.$detail->laporan_kegiatan->foto_dokumentasi) }}" style="width: 150px; height: 150px;">
                                    @else
                                    <input type="file" class="form-control" name="foto_dokumentasi" id="foto_dokumentasi">
                                    @error("foto_dokumentasi")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!empty($detail->laporan_kegiatan))
                        
                        @else
                        <hr>
                        <button type="reset" class="btn btn-danger btn-sm">
                            BATAL
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            SIMPAN
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
