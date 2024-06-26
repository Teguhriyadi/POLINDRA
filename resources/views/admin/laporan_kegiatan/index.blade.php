@extends("layouts.main")

@section("title", "Laporan Kegiatan")

@section("css")

<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">

@endsection

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Semua Data Laporan Kegiatan
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No.</th>
                                <th>Nama UKM</th>
                                <th>Nama Kegiatan</th>
                                <th style="text-align: center;">File Laporan</th>
                                <th style="text-align: center;">File Gambar</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $item)
                                @if (empty($item->file_surat_balasan))
                                
                                @else
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item->users->nama }}</td>
                                    <td>{{ $item["nama_kegiatan"] }}</td>
                                    <td class="text-center">
                                        @if (empty($item["laporan_kegiatan"]["file_lpj"]))
                                        <strong>
                                            <i>
                                                Belum Ada File Laporan
                                            </i>
                                        </strong>
                                        @else
                                        <a target="_blank" href="{{ url('/super_admin/laporan_kegiatan/lpj/'.$item["laporan_kegiatan"]["id"]) }}">
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
                                        @if (empty($item->laporan_kegiatan))
                                        <button class="btn btn-danger btn-sm">
                                            Kegiatan Berlangsung
                                        </button>
                                        @else
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i> Kegiatan Selesai
                                        </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/super_admin/laporan_kegiatan/show/'.$item["id"]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
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