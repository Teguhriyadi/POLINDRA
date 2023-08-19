@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kegiatan Bulan {{ $bulan }} Tahun {{ $tahun }} </title>
    
    <style>
        body {
            margin: 0px;
            padding: 0px;
            font-family: Arial, Helvetica, sans-serif;
        }
        
        .heading {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .teks-tengah {
            text-align: center;
        }
        
    </style>
    
</head>
<body>
    
    <center>
        <div class="heading">
            Data Laporan Kegiatan Bulan {{ $bulan }} Tahun {{ $tahun }}
        </div>
    </center>
    
    <br><br>
    
    <table style="width: 100%" border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th class="teks-tengah">No.</th>
                <th style="text-align: left;">Nama Kegiatan</th>
                <th style="text-align: left;">Tempat Pelaksanaan</th>
                <th class="teks-tengah">Mulai</th>
                <th class="teks-tengah">Akhir</th>
                <th class="teks-tengah">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
            $nomer = 0;
            @endphp
            @foreach ($izin_kegiatan as $item)
            <tr>
                <td class="teks-tengah">{{ ++$nomer }}.</td>
                <td>{{ $item["nama_kegiatan"] }}</td>
                <td>{{ $item["tempat_pelaksanaan"] }}</td>
                <td class="teks-tengah">
                    @php
                    $mulai = Carbon::createFromFormat('Y-m-d H:i:s', $item->mulai);
                    $format = $mulai->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                    echo $format;
                    @endphp
                </td>
                <td class="teks-tengah">
                    @php
                    $akhir = Carbon::createFromFormat('Y-m-d H:i:s', $item->akhir);
                    $format = $akhir->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
                    echo $format;
                    @endphp
                </td>
                <td class="teks-tengah">
                    @if ($item["status"] == "1")
                        Sudah di Validasi    
                    @elseif($item["status"] == "0")
                        Belum di Konfirmasi
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>