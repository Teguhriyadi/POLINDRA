@php
    use Carbon\Carbon;
@endphp

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
                        @if (!empty(session("bulan")))
                        Bulan
                        <strong>
                            {{ Carbon::createFromDate(null, session("bulan"), null)->translatedFormat('F'); }}
                        </strong>
                        Tahun
                        <strong>
                            {{ session("tahun") }}
                        </strong>
                            @if (!session("izin_kegiatan")->count() == 0)
                            <a href="{{ url('/ormawa/izin_kegiatan/'. session("bulan") . '/' . session("tahun")) }}" class="btn btn-primary btn-sm pull-right">
                                <i class="fa fa-download"></i> Download Data
                            </a>
                            @endif
                        @endif
                    </h3>
                    
                    <hr>
                    
                    <form action="{{ url('/ormawa/izin_kegiatan') }}" method="POST">
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
                            @if (empty(session("izin_kegiatan")))
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
                            @else
                                @foreach (session("izin_kegiatan") as $item)
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