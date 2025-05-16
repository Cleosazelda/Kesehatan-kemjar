<!-- Sidebar -->
@if (auth()->check())
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #4682A9" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard')}}">
        <div class="sidebar-brand-icon">
            <img src="{{asset('landing/asset/img/tooth_logo.png')}}" style="width: 60px" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">Exsys Bayes</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('index')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Feature
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="{{ route('evidence.index') }}">Evidence</a>
                <a class="collapse-item" href="{{ route('hypothesis.index') }}">Hypohtesis</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Rule -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rule.index') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Rule</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('expert_system')}}">
            <i class="fas fa-fw fa-brain"></i>
            <span>Expert System</span></a>
    </li>
    <!-- Nav Item - Diagnosis -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('diagnosis.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Diagnosis</span></a>
    </li>
    @if (auth()->user()->role == 'admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Setting
    </div> 
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Setting</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="{{ route('setting.index') }}">Application</a>
                <a class="collapse-item" href="{{ route('user.index') }}">User</a>
            </div>
        </div>
    </li>
    @endif
    
    

    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
{{-- @else
    <!-- Nav Item - User -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('index')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('expert_system')}}">
            <i class="fas fa-fw fa-brain"></i>
            <span>Expert System</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login')}}">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Login</span></a> --}}
    {{-- </li> --}}
@endif
<!-- End of Sidebar -->