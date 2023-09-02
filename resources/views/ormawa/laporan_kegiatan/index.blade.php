@php
    use Carbon\Carbon;
@endphp

@extends("layouts.main")

@section("title", "Laporan Kegiatan")

@section("css")

<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">

@endsection

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            @if (session("message"))
            <div class="alert alert-success">
                <strong>Berhasil, </strong> {!! session("message") !!}
            </div>
            @endif

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Semua Data Laporan Kegiatan
                        @if (!empty(session("bulan")))
                        Bulan
                        <strong>
                            {{ Carbon::createFromDate(null, session("bulan"), null)->translatedFormat('F'); }}
                        </strong>
                        Tahun
                        <strong>
                            {{ session("tahun") }}
                        </strong>
                            @if (!session("laporan")->count() == 0)
                            <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/'. session("bulan") . '/' . session("tahun")) }}" class="btn btn-primary btn-sm pull-right">
                                <i class="fa fa-download"></i> Download Data
                            </a>
                            @endif
                        @else
                        Bulan
                        <strong>
                            {{ $c_bulan }}
                        </strong>
                        Tahun
                        <strong>
                            {{ $tahun }}
                        </strong>
                        @endif
                    </h3>

                    <hr>

                    <form action="{{ url('/ormawa/laporan_kegiatan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-sm-1" style="margin-top: 5px;"> Filter : </label>
                                <div class="col-md-3">
                                    <select name="bulan" class="form-control" id="bulan" required>
                                        <option value="">- Pilih Bulan -</option>
                                        @for ($bulan = 1; $bulan <= 12; $bulan++)
                                            @php
                                                $formattedBulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                                                $namaBulan = \Carbon\Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');
                                            @endphp
                                            <option value="{{ $formattedBulan }}" {!! session("bulan") == $formattedBulan ? 'selected' : '' !!} >{{ $namaBulan }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="tahun" class="form-control" id="tahun" required>
                                        <option value="">- Pilih Tahun -</option>
                                        @foreach ($tahun_range as $item)
                                            @if (empty(session("tahun")))
                                            <option value="{{ $item }}">
                                                {{ $item }}
                                            </option>
                                            @else
                                            <option value="{{ $item }}" {{ session("tahun") == $item ? 'selected' : '' }} >
                                                {{ $item }}
                                            </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary btn-sm" value="FILTER">
                                </div>
                            </div>
                            @error("filter_role")
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </form>

                </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="text-align: center">No.</th>
                                <th>Nama Kegiatan</th>
                                <th style="text-align: center">File LPJ</th>
                                <th style="text-align: center">Foto Dokumentasi</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty(session("laporan")))
                            @foreach ($laporan as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $item["nama_kegiatan"] }}</td>
                                <td class="text-center">
                                    @if (empty($item["laporan_kegiatan"]["file_lpj"]))
                                    <strong>
                                        <i>
                                            Belum Ada File Laporan
                                        </i>
                                    </strong>
                                    @else
                                    <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/lpj/'.$item["laporan_kegiatan"]["id"]) }}">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (empty($item["laporan_kegiatan"]["foto_dokumentasi"]))
                                        <strong>
                                            <i>
                                                Belum Ada Foto Dokumentasi
                                            </i>
                                        </strong>
                                    @else
                                    <img src="{{ url('storage/'.$item["laporan_kegiatan"]["foto_dokumentasi"]) }}" style="width: 50px; height: 50px">
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (!empty($item->laporan_kegiatan))
                                    <button  class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Kegiatan Selesai
                                    </button>
                                    @else
                                    <button class="btn btn-danger btn-sm">
                                        Kegiatan Berlangsung
                                    </button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (empty($item->laporan_kegiatan))
                                    <a href="{{ url('/ormawa/laporan_kegiatan/unggah/'.$item["id"]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-plus"></i> Unggah Laporan
                                    </a>
                                    @endif
                                    <a href="{{ url('/ormawa/laporan_kegiatan/show/'.$item["id"]) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-search"></i> Detail
                                    </a>
                                    @if (!empty($item->laporan_kegiatan))
                                    <a href="{{ url('/ormawa/laporan_kegiatan/edit/'.$item["id"]) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                            @else
                                @foreach (session("laporan") as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item["izin"]["nama_kegiatan"] }}</td>
                                    <td class="text-center">
                                        @if (empty($item["file_lpj"]))
                                        <strong>
                                            <i>
                                                Belum Ada File Laporan
                                            </i>
                                        </strong>
                                        @else
                                        <a target="_blank" href="{{ url('/ormawa/laporan_kegiatan/lpj/'.$item["id"]) }}">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (empty($item["foto_dokumentasi"]))
                                            <strong>
                                                <i>
                                                    Belum Ada Foto Dokumentasi
                                                </i>
                                            </strong>
                                        @else
                                        <img src="{{ url('storage/'.$item["foto_dokumentasi"]) }}" style="width: 50px; height: 50px">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!empty($item))
                                        <button  class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i> Kegiatan Selesai
                                        </button>
                                        @else
                                        <button class="btn btn-danger btn-sm">
                                            Kegiatan Berlangsung
                                        </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (empty($item))
                                        <a href="{{ url('/ormawa/laporan_kegiatan/unggah/'.$item["id"]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Unggah Laporan
                                        </a>
                                        @endif
                                        <a href="{{ url('/ormawa/laporan_kegiatan/show/'.$item["id"]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("javascript")

<script src="{{ url('/javascript/dataTables.min.js') }}"></script>
<script src="{{ url('/javascript/bootstrap.min.js') }}"></script>
<script>
    $('#example').DataTable();
</script>

@endsection