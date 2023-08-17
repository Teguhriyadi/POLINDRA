<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="index.html">
            <img src="{{ url('') }}/assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo">
        </a>
    </div>
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
        </div>
        
        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if (empty(Auth::user()->foto))
                        <img src="{{ url('') }}/assets/img/user.png" class="img-circle" alt="Avatar">
                        @else
                        <img src="{{ url('storage/'.Auth::user()->foto) }}" class="img-circle" alt="Avatar">
                        @endif
                        <span>
                            {{ Auth::user()->nama }}
                        </span> 
                        <i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            @if (Auth::user()->role == "admin")
                            <a href="{{ url('/super_admin/profil_saya') }}">
                            @elseif(Auth::user()->role == "wadir")
                            <a href="{{ url('/wadir/profil_saya') }}">
                            @elseif(Auth::user()->role == "ormawa")
                            <a href="{{ url('/ormawa/profil_saya') }}">
                            @endif
                            
                                <i class="lnr lnr-user"></i> 
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}">
                                <i class="lnr lnr-exit"></i> 
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>