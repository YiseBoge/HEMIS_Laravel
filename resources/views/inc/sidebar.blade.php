<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top"
    style="height: 100vh;"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-2" href="/">
        <div class="sidebar-brand-icon">
            <img class="rounded-circle d-inline-block shadow-sm" width="50" height="50"
                 src="{{ asset('img/logo.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">
            <img class="d-inline-block" height="45" src="{{ asset('img/brand.png') }}">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ preg_split ("/\./", $page_name)[1] == 'dashboard' ? 'active': '' }}">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if(Auth::user()->hasRole('Department Admin'))

        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'enrollment' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEnrollment"
               aria-expanded="false"
               aria-controls="collapseStudents">
                <i class="fas fa-user-graduate"></i>
                <span>Enrollment</span>
            </a>
            <div id="collapseEnrollment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'normal' ? 'active': '' }}"
                       href="/enrollment/normal">Students</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'special_region_students' ? 'active': '' }}"
                       href="/enrollment/special-region-students">Special Region Students</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'specializing_student_enrollment' ? 'active': '' }}"
                       href="/enrollment/specializing-students">Specializing Students</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'rural_students' ? 'active': '' }}"
                       href="/enrollment/rural-area-students">Rural Area Students</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'disadvantaged_students' ? 'active': '' }}"
                       href="/enrollment/economically-disadvantaged">Economically
                        Disadvantaged Students</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'other_region_students' ? 'active': '' }}"
                       href="/enrollment/other-region-students">Students From Other
                        Regions</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'age_enrollment' ? 'active': '' }}"
                       href="/enrollment/age-enrollment">Enrollment With Age</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'joint_program' ? 'active': '' }}"
                       href="/enrollment/joint-program">Joint Programs</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'students' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
            <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Details:</h6>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'foreign' ? 'active': '' }}"
                       href="/student/foreign">Foreigner Students</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'special_need' ? 'active': '' }}"
                       href="/student/special-need">Special Need Students</a>

                    <h6 class="collapse-header">Aggregates:</h6>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'student_attrition' ? 'active': '' }}"
                       href="/student/student-attrition">Student Attrition</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'other_attrition' ? 'active': '' }}"
                       href="/student/other-attrition">Other Information</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'exit_examination' ? 'active': '' }}"
                       href="/student/exit-examination">Exit Examination</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'degree_employment' ? 'active': '' }}"
                       href="/student/degree-relevant-employment">Degree Relevant
                        Employment</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'cost_sharing' ? 'active': '' }}"
                       href="/student/cost-sharing">Cost Sharing</a>

                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'staff' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff"
               aria-controls="collapseStaff">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Staff</span>
            </a>
            <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Details:</h6>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'academic' ? 'active': '' }}"
                       href="/staff/academic">Academic Staff</a>

                    <h6 class="collapse-header">Aggregates:</h6>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'teachers' ? 'active': '' }}"
                       href="/department/teachers">Teachers</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'upgrading-staff' ? 'active': '' }}"
                       href="/department/upgrading-staff">Staff Upgrading Level of
                        Education</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'special-program-teacher' ? 'active': '' }}"
                       href="/department/special-program-teacher">Special Programs</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'postgraduate_diploma_training' ? 'active': '' }}"
                       href="/department/postgraduate-diploma-training">Post Graduate
                        Diploma Training</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'diaspora_course' ? 'active': '' }}"
                       href="/department/diaspora-courses">Courses and Researches
                        By Ethiopian Diaspora</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'attrition' ? 'active': '' }}"
                       href="/staff/attrition">Staff Attrition</a>
                </div>
            </div>
        </li>


        <li class="nav-item {{ preg_split ("/\./", $page_name)[1] == 'research' ? 'active': '' }}">
            <a class="nav-link" href="/institution/researches">
                <i class="fas fa-microscope"></i>
                <span>Research</span></a>
        </li>

        <li class="nav-item {{ preg_split ("/\./", $page_name)[1] == 'publications' ? 'active': '' }}">
            <a class="nav-link" href="/department/publication">
                <i class="fas fa-book"></i>
                <span>Publications</span></a>
        </li>


    @elseif(Auth::user()->hasRole('College Admin'))
        <hr class="sidebar-divider">

        <li class="nav-item" {{ preg_split ("/\./", $page_name)[0] == 'budgets' ? 'active': '' }}>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBudget"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-university"></i>
                <span>Budgets</span>
            </a>
            <div id="collapseBudget" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'budget' ? 'active': '' }}"
                       href="/budgets/budget">Budget</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'internal-revenue' ? 'active': '' }}"
                       href="/budgets/internal-revenue">Internal Revenue</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'investment' ? 'active': '' }}"
                       href="/budgets/private-investment">Private Investment</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'students' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
            <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'university_industry_linkage' ? 'active': '' }}"
                       href="/student/university-industry-linkage">University Industry
                        Linkage</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'staff' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff"
               aria-controls="collapseStaff">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Staff</span>
            </a>
            <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Details:</h6>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'technical' ? 'active': '' }}"
                       href="/staff/technical">Technical Staff</a>
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'ict' ? 'active': '' }}"
                       href="/staff/ict">ICT Staff</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'administrative' ? 'active': '' }}"
                       href="/staff/administrative">Administrative Staff</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'management' ? 'active': '' }}"
                       href="/staff/management">Management Staff</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'supportive' ? 'active': '' }}"
                       href="/staff/supportive">Supportive Staff</a>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'attrition' ? 'active': '' }}"
                       href="/staff/attrition">Staff Attrition</a>

                    <h6 class="collapse-header">Aggregates:</h6>
                    <a class="collapse-item text-wrap {{ preg_split ("/\./", $page_name)[1] == 'admin_and_non_academic_staff' ? 'active': '' }}"
                       href="/institution/non-admin">Administrative and Non-Academic
                        Staff</a>

                </div>
            </div>
        </li>

        <li class="nav-item {{ preg_split ("/\./", $page_name)[1] == 'buildings' ? 'active': '' }}">
            <a class="nav-link" href="/institution/buildings">
                <i class="fas fa-building"></i>
                <span>Buildings</span></a>
        </li>
    @elseif(Auth::user()->hasRole('College Super Admin'))
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBudget"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-university"></i>
                <span>Budgets</span>
            </a>
            <div id="collapseBudget" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/budgets/budget">Budget</a>
                    <a class="collapse-item" href="/budgets/internal-revenue">Internal Revenue</a>
                    <a class="collapse-item" href="/budgets/private-investment">Private Investment</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
               aria-expanded="false"
               aria-controls="collapseStudents">
                <i class="fas fa-user-graduate"></i>
                <span>Enrollment</span>
            </a>
            <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/enrollment/normal">Students</a>
                    <a class="collapse-item" href="/enrollment/special-region-students">Special Region Students</a>
                    <a class="collapse-item" href="/student/special-need">Special Need Students</a>
                    <a class="collapse-item" href="/enrollment/specializing-students">Specializing Students</a>
                    <a class="collapse-item" href="/enrollment/rural-area-students">Rural Area Students</a>
                    <a class="collapse-item text-wrap" href="/enrollment/economically-disadvantaged">Economically
                        Disadvantaged Students</a>
                    <a class="collapse-item text-wrap" href="/enrollment/other-region-students">Students From Other
                        Regions</a>
                    <a class="collapse-item" href="/enrollment/age-enrollment">Enrollment With Age</a>
                    <a class="collapse-item" href="/enrollment/joint-program">Joint Programs</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent"
               aria-expanded="false"
               aria-controls="collapseInstitution">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
            <div id="collapseStudent" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Details:</h6>
                    <a class="collapse-item" href="/student/foreign">Foreigner Students</a>
                    <a class="collapse-item" href="/student/special-need">Special Need Students</a>

                    <h6 class="collapse-header">Aggregates:</h6>
                    <a class="collapse-item" href="/student/student-attrition">Student Attrition</a>
                    <a class="collapse-item" href="/student/other-attrition">Other Information</a>
                    <a class="collapse-item" href="/student/exit-examination">Exit Examination</a>
                    <a class="collapse-item text-wrap" href="/student/degree-relevant-employment">Degree Relevant
                        Employment</a>
                    <a class="collapse-item text-wrap" href="/student/university-industry-linkage">University Industry
                        Linkage</a>
                    <a class="collapse-item text-wrap" href="/student/cost-sharing">Cost Sharing</a>

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
                    <h6 class="collapse-header">Details:</h6>
                    <a class="collapse-item" href="/staff/academic">Academic Staff</a>
                    <a class="collapse-item" href="/staff/technical">Technical Staff</a>
                    <a class="collapse-item" href="/staff/ict">ICT Staff</a>
                    <a class="collapse-item text-wrap" href="/staff/administrative">Administrative Staff</a>
                    <a class="collapse-item text-wrap" href="/staff/management">Management Staff</a>
                    <a class="collapse-item text-wrap" href="/staff/supportive">Supportive Staff</a>
                    <a class="collapse-item text-wrap" href="/staff/attrition">Staff Attrition</a>

                    <h6 class="collapse-header">Aggregates:</h6>
                    <a class="collapse-item" href="/department/teachers">Teachers</a>
                    <a class="collapse-item text-wrap" href="/department/upgrading-staff">Staff Upgrading Level of
                        Education</a>
                    <a class="collapse-item text-wrap" href="/department/special-program-teacher">Special Programs</a>
                    <a class="collapse-item text-wrap" href="/department/postgraduate-diploma-training">Post Graduate
                        Diploma Training</a>
                    <a class="collapse-item text-wrap" href="/department/diaspora-courses">Courses and Researches
                        By Ethiopian Diaspora</a>
                    <a class="collapse-item text-wrap" href="/staff/attrition">Staff Attrition</a>
                    <a class="collapse-item text-wrap" href="/institution/non-admin">Administrative and Non-Academic
                        Staff</a>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="/institution/researches">
                <i class="fas fa-microscope"></i>
                <span>Research</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/department/publication">
                <i class="fas fa-book"></i>
                <span>Publications</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/institution/buildings">
                <i class="fas fa-building"></i>
                <span>Buildings</span></a>
        </li>
    @elseif(Auth::user()->hasRole('University Admin'))

        <hr class="sidebar-divider">

        <li class="nav-item {{ preg_split ("/\./", $page_name)[1] == 'general_info' ? 'active': '' }}">
            <a class="nav-link" href="/institution/general">
                <i class="fas fa-info-circle"></i>
                <span>General Information</span></a>
        </li>

    @elseif(Auth::user()->hasRole('Super Admin'))
        <hr class="sidebar-divider">

        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'report' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
               aria-expanded="false"
               aria-controls="collapseReport">
                <i class="fas fa-university"></i>
                <span>Report</span>
            </a>
            <div id="collapseReport" class="collapse" aria-labelledby="headingTwo"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'report_card' ? 'active': '' }}"
                       href="/report">MoSHE Report Card</a>
                </div>
            </div>
        </li>
    @else

    @endif

    <hr class="sidebar-divider">

    @if(!Auth::user()->hasRole('Department Admin'))
        <div class="sidebar-heading">
            Management Components
        </div>

        <li class="nav-item {{ preg_split ("/\./", $page_name)[0] == 'administer' ? 'active': '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
               aria-controls="collapseAdmin">
                <i class="fas fa-toolbox"></i>
                <span>Administer</span>
            </a>
            <div id="collapseAdmin" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->hasRole('Super Admin'))
                        <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'instance' ? 'active': '' }}"
                           href="/institution/instance">Instances</a>
                        @if (Auth::user()->currentInstance != null)
                            <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'institution-name' ? 'active': '' }}"
                               href="/institution/institution-name">University Names</a>
                            @if(!\App\Models\Institution\InstitutionName::all()->isEmpty())
                                <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'university_admin' ? 'active': '' }}"
                                   href="/university-admin">University Admin</a>
                            @endif
                            <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'region-name' ? 'active': '' }}"
                               href="/region-name">Region Names</a>
                            <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'band-name' ? 'active': '' }}"
                               href="/band/band-name">Band/ICED Names</a>
                        @endif
                    @elseif(Auth::user()->hasRole('University Admin'))
                        <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'colleges-name' ? 'active': '' }}"
                           href="/college/college-name">College/Institute Names</a>
                        <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'department-name' ? 'active': '' }}"
                           href="/department/department-name">School/Department Names</a>
                        @if(!\App\Models\College\CollegeName::all()->isEmpty())
                            <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'college_admin' ? 'active': '' }}"
                               href="/college-admin">College/Institute Admin</a>
                        @endif
                        <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'ict_staff_type' ? 'active': '' }}"
                           href="/staff/ict-staff-types">ICT Staff Types</a>
                        <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'budget-description' ? 'active': '' }}"
                           href="/budgets/budget-description">Budget Descriptions</a>
                    @elseif(Auth::user()->hasRole('College Admin'))
                        @if(!\App\Models\Department\DepartmentName::all()->isEmpty())
                            <a class="collapse-item {{ preg_split ("/\./", $page_name)[1] == 'department_admin' ? 'active': '' }}"
                               href="/department-admin">School/Department Admins</a>
                        @endif
                    @endif

                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
@endif

<!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
