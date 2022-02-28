  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Altara</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
    </div>
    <li class="nav-item active">
        <a class="nav-link" href="{{route('send-message')}}">
            <i class="fas fa-calendar"></i>
            <span>Send Message</span></a>
    </li>
    {{-- <li class="nav-item active">
        <a class="nav-link" href="{{ route('courses.index') }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Courses</span></a>
    </li>
    
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-users"></i>
            <span>Students</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('lecturers.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Lecturers</span></a>
    </li> --}}
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->