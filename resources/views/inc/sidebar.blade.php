<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{config('app.name', 'HEMIS')}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Major Components
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInstitution"
           aria-expanded="false"
           aria-controls="collapseInstitution">
            <i class="fas fa-university"></i>
            <span>Institution</span>
        </a>
        <div id="collapseInstitution" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Institution Info:</h6>
                <a class="collapse-item" href="/institution/budget">Budget</a>
                <a class="collapse-item" href="/institution/internal-revenue">Internal Revenue</a>
                <a class="collapse-item" href="/institution/private-investment">Private Investments</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
           aria-expanded="false"
           aria-controls="collapseStudents">
            <i class="fas fa-user-graduate"></i>
            <span>Students</span>
        </a>
        <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Acts:</h6>
                <a class="collapse-item" href="/student/disabled">Disabled Students</a>
                <a class="collapse-item" href="/student/foreigner">Foreigner Students</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff"
           aria-controls="collapseStaff">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Staff</span>
        </a>
        <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Staff Acts:</h6>
                <a class="collapse-item" href="/staff/academic">Academic Staff</a>
                <a class="collapse-item" href="/staff/technical">Technical Staff</a>
                <a class="collapse-item" href="/staff/administrative">Administrative Staff</a>
                <a class="collapse-item" href="/staff/ict">ICT Staff</a>
                <a class="collapse-item" href="/staff/supportive">Supportive Staff</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Lesser Components
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/admin">
            <i class="fas fa-user-cog"></i>
            <span>Admin</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
