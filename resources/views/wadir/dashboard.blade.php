@extends("layouts.main")

@section("title", "Dashboard")

@section('content')

<div class="main">
    <div class="main-content">
        <div class="container-fluid">

            @if (session("message"))
            <div class="alert alert-success">
                <strong>
                    {!! session("message") !!}
                </strong>. Anda Login Sebagai <strong>Wadir</strong>
                <hr>
                <p>
                    Silahkan Pilih Menu Untuk Memulai Program
                </p>
            </div>
            @endif

            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Dashboard Wadir
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-book"></i></span>
                                <p>
                                    <span class="number">{{ $izin_kegiatan }}</span>
                                    <span class="title">Izin Kegiatan</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-times"></i></span>
                                <p>
                                    <span class="number">{{ $ditolak }}</span>
                                    <span class="title">Kegiatan Ditolak</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-check"></i></span>
                                <p>
                                    <span class="number">{{ $disetujui }}</span>
                                    <span class="title">Kegiatan Disetujui</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                <p>
                                    <span class="number">{{ $laporan }}</span>
                                    <span class="title">Laporan Kegiatan</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($kegiatan) > 0)
                <div class="panel panel-headline">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('javascript')
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    const ctx = document.getElementById("myChart");

    const dataperbulan = Array.from({length: 12}, () => 0)

    @foreach ($kegiatan as $izin)
        @php
            $bulanIndex = date('n', strtotime($izin->created_at)); // Bulan -> n = Bulan
            $tahun = date("Y", strtotime($izin->created_at)) // Tahun -> Y = Tahun
        @endphp

        @if ($tahun == date("Y")) // Tahun Created At == Tahun nya Si Laptop Yang Dipakai / Timezone Dari Laptop
            dataperbulan[{{$bulanIndex - 1}}]++;
        @endif
    @endforeach

    function getLabelBulan(bulan) {
        const namabulan = new Date(0, bulan - 1).toLocaleString("default", {month: "long"})
        return namabulan.substring(0,10);
    }

    const labelsBulan = [];
    for (let i = 1; i <= 12; i++) {
        labelsBulan.push(getLabelBulan(i)); // Push = Menambahkan , 
        // 1 : Januari
        // 2 : Februari
        // 3 : Maret
        // DLL : Desember
    }

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labelsBulan,
            datasets: [{
                label: "Monitoring Keseluruhan Pertahun Ini",
                data: dataperbulan,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    })
</script>

@endsection