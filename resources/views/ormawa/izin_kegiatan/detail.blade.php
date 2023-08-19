@php
    use Carbon\Carbon;
@endphp

@extends("layouts.main")

@section("title", "Detail Kegiatan")

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            <a href="{{ url('/ormawa/izin_kegiatan') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out"></i> KEMBALI 
            </a>

            <br><br>

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Detail Izin Kegiatan
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
                            <label for="unggah_file" class="control-label col-md-3"> File Izin Kegiatan </label>
                            <div class="col-md-7">
                                <a href="" class="btn btn-primary btn-sm">
                                    <i class="fa fa-download"></i> UNDUH FILE
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($detail->status == 1)
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-3"> Status </label>
                            <div class="col-md-7">
                                <button class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Disetujui Wadir
                                </button>
                            </div>
                        </div>
                    </div>
                    @elseif($detail->status == 2)
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-3"> Status </label>
                            <div class="col-md-7">
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i> Ditolak Wadir
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-3"> Komentar </label>
                            <div class="col-md-7">
                                <strong>
                                    <span class="text-danger">
                                        {{ $detail->komentar }}
                                    </span>
                                </strong>
                            </div>
                        </div>
                    </div>
                    @elseif($detail->status == 3)
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-3"> Status </label>
                            <div class="col-md-7">
                                <button class="btn btn-info btn-sm">
                                    <i class="fa fa-refresh"></i> Pengajuan Ulang Kepada Wadir
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-3"> Komentar Sebelumnya </label>
                            <div class="col-md-7">
                                <strong>
                                    <span class="text-danger">
                                        {{ $detail->komentar }}
                                    </span>
                                </strong>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
