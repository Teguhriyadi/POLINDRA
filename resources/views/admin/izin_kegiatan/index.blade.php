@extends("layouts.main")

@section("title", "Izin Kegiatan")

@section("css")

<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">

@endsection

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            @if (session("message"))
            <div class="alert alert-success">
                {!! session("message") !!}
            </div>
            @endif

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Data Izin Kegiatan
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No.</th>
                                <th>Nama UKM</th>
                                <th>Nama Kegiatan</th>
                                <th style="text-align: center;">File Surat</th>
                                <th style="text-align: center;">File Surat Balasan</th>
                                <th>Tempat</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($izin_kegiatan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item["users"]["nama"] }}</td>
                                    <td>{{ $item["nama_kegiatan"] }}</td>
                                    <td class="text-center">
                                        <a target="_blank" href="{{ url('/super_admin/izin_kegiatan/download/'.$item->id) }}">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if (empty($item["file_surat_balasan"]))
                                            <strong>
                                                <i>
                                                    Belum Ada Surat Balasan    
                                                </i>    
                                            </strong>    
                                        @else
                                            <a target="_blank" href="{{ url('/super_admin/izin_kegiatan/balasan/'.$item->id) }}">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $item["tempat_pelaksanaan"] }}</td>
                                    <td class="text-center">
                                        @if ($item["status"] == "0")
                                            <button class="btn btn-warning btn-sm">
                                                <i class="fa fa-times"></i> Belum Dikonfirmasi
                                            </button>
                                        @elseif($item["status"] == "1")
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i> Sudah di Validasi
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/super_admin/izin_kegiatan/show/'.$item["id"]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> DETAIL
                                        </a>
                                    </td>
                                </tr>
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