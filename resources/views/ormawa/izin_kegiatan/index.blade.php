@extends("layouts.main")

@section("title", "Izin Kegiatan")

@section("css")

<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">

@endsection

@section('content')

<div class="main" style="padding-top: 120px;">
    <div class="main-content">
        <div class="container-fluid">

            <a href="{{ url('/ormawa/izin_kegiatan/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> TAMBAH
            </a>
            
            <br><br>

            @if (session("message"))
            <div class="alert alert-success">
                <strong>Berhasil, </strong>
                {!! session("message") !!}
            </div>
            @endif

            @if (session("message_error"))
            <div class="alert alert-danger">
                <strong>Maaf, </strong>
                {!! session("message_error") !!}
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
                                <th class="text-center">No.</th>
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
                                    <td>{{ $item["nama_kegiatan"] }}</td>
                                    <td class="text-center">
                                        <a target="_blank" href="{{ url('/ormawa/izin_kegiatan/download/'.$item->id) }}">
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
                                            <a target="_blank" href="{{ url('/ormawa/izin_kegiatan/balasan/'.$item->id) }}">
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
                                        @elseif($item["status"] == "2")
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-times"></i> Tidak Disetujui
                                        </button>
                                        @elseif($item["status"] == "3")
                                        <button class="btn btn-info btn-sm">
                                            <i class="fa fa-refresh"></i> Pengajuan Ulang
                                        </button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/ormawa/izin_kegiatan/show/'.$item["id"]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> DETAIL
                                        </a>
                                        @if ($item->status == 1)
                                            
                                        @elseif($item->status == 2)
                                        <a href="{{ url('/ormawa/izin_kegiatan/ulang/'.$item["id"]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-refresh"></i> Pengajuan Ulang
                                        </a>
                                        
                                        @elseif($item->status == 0)
                                        <a href="{{ url('/ormawa/izin_kegiatan/edit/'.$item["id"]) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> EDIT
                                        </a>
                                        @endif
                                        @if ($item["status"] != 0)
                                            
                                        @else
                                        <form action="{{ url('/ormawa/izin_kegiatan/destroy/'.$item["id"]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method("DELETE")
                                            <button onclick="return confirm('Yakin ? Apakah Ingin Menghapus Data Ini ?')" type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> HAPUS
                                            </button>
                                        </form>
                                        @endif
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