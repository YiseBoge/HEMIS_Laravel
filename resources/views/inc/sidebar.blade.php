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
    @if (Auth::user()->hasRole('Super Admin'))
        <div class="sidebar-heading">
            Lesser Components
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
            aria-controls="collapseAdmin">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Admin</span>
            </a>
            <div id="collapseAdmin" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Admin Acts:</h6>
                    <a class="collapse-item" href="/institution/instance">Instances</a>
                    <a class="collapse-item" href="/college/budget-description">Budget Description</a>
                    <a class="collapse-item" href="/editors">Editors</a>
                    <a class="collapse-item" href="/institution/institution-name">Institution Names</a>
                    <a class="collapse-item" href="/band/band-name">Band Names</a>
                    <a class="collapse-item" href="/college/college-name">College Names</a>
                    <a class="collapse-item" href="/department/department-name">Department Names</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @else 
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
                    <a class="collapse-item" href="/institution/researches">Research</a>
                    <a class="collapse-item" href="/institution/university-industry-linkage">University Industry Linkage</a>
                    <a class="collapse-item" href="/institution/genral-information">General Information</a>
                    <a class="collapse-item" href="/institution/buildings">Buildings</a>
                </div>
            </div>
        </li>
    
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
               aria-expanded="false"
               aria-controls="collapseStudents">
                <i class="fas fa-user-graduate"></i>
                <span>Enrollment</span>
            </a>
            <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/enrollment/normal">Normal Students</a>
                    <a class="collapse-item" href="/enrollment/special-region-students">Special Region Students</a>
                    <a class="collapse-item" href="/enrollment/specializing-students">Specializing Students</a>
                    <a class="collapse-item" href="/institution/age-enrollment">Enrollment With Age</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-university"></i>
                <span>Students</span>
            </a>
            <div id="collapseStudent" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/student/foreign">Foreign Students</a>
                    <a class="collapse-item" href="/student/special-need">Special Need Students</a>
                    <a class="collapse-item" href="/student/student-attrition">Student Attrition</a>
                    <a class="collapse-item" href="/student/other-attrition">Other Attrition</a>
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
                    <a class="collapse-item" href="/department/expatriate-staff">Expatriate Staff</a>
                    <a class="collapse-item" href="/department/teachers">Teachers</a>
                    <a class="collapse-item" href="/institution/foreign-staff">Foreign Academic Staff</a>
                    <a class="collapse-item text-wrap" href="/department/staff-leave">Study Leave</a>
                    <a class="collapse-item text-wrap" href="/department/upgrading-staff">Upgrading Level of Education</a>
                    <a class="collapse-item" href="/staff/technical-staff">Technical Staff</a>
                    <a class="collapse-item text-wrap" href="/institution/non-admin">Administrative and Non-Academic Staff</a>
                    <a class="collapse-item text-wrap" href="/staff/administrative">Administrative Staff(Detail)</a>
                    <a class="collapse-item text-wrap" href="/department/special-program-teacher">Special Programs</a>
                    <a class="collapse-item text-wrap" href="/department/postgraduate-diploma-training">Post Graduate
                        Diploma Training</a>
                    <a class="collapse-item text-wrap" href="/institution/management-data">Managment Data</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
    <hr class="sidebar-divider">
    
    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
