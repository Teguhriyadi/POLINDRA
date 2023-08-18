<div id="sidebar-nav" class="sidebar" style="margin-top: 30px;">
    <div class="sidebar-scroll">
        @if (Auth::user()->role == "admin")
            @include("layouts.sidebar-admin")    
        @elseif(Auth::user()->role == "wadir")
            @include("layouts.sidebar-wadir")
        @elseif(Auth::user()->role == "ormawa")
            @include("layouts.sidebar-ormawa")
        @endif
    </div>
</div>