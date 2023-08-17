<nav>
    <ul class="nav">
        <li>
            <a href="{{ url('/ormawa/dashboard') }}" class="{{ Request::segment(2) == "dashboard" ? 'active' : '' }}">
                <i class="lnr lnr-home"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/ormawa/izin_kegiatan') }}" class="{{ Request::segment(2) == "izin_kegiatan" ? 'active' : '' }}">
                <i class="fa fa-edit"></i> 
                <span>Izin Kegiatan</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/ormawa/laporan_kegiatan') }}" class="{{ Request::segment(2) == "laporan_kegiatan" ? 'active' : '' }}">
                <i class="fa fa-bar-chart"></i>
                <span>Laporan Kegiatan</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/ormawa/profil_saya') }}" class="{{ Request::segment(2) == "profil_saya" ? 'active' : '' }}">
                <i class="fa fa-edit"></i>
                <span>Profil Saya</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/ormawa/ganti_password') }}" class="{{ Request::segment(2) == "ganti_password" ? 'active' : '' }}">
                <i class="fa fa-key"></i>
                <span>Ganti Password</span>
            </a>
        </li>
    </ul>
</nav>