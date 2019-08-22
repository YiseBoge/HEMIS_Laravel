@extends('layouts.app')

@section('index_content')
    @guest
        <!-- Masthead -->
        <header class="masthead text-white text-center" style="min-height: 650px;
                background: url('{{asset('/img/landing.jpg')}}') no-repeat center center;
                background-size: cover;">
            <div class="overlay shadow d-block"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <h1>Welcome to the MoSHE - Higher Education Management Information System</h1>
                    </div>
                </div>
            </div>
        </header>
    @endguest

    <!-- Icons Grid -->
    @guest()
        <section class="features-icons bg-light text-center">
            @else
                <section class="features-icons bg-light text-center"
                         style="background: url('{{asset('img/landing.jpg')}}') top no-repeat; background-size: cover;">
                    @endguest
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 p-3 py-lg-0">
                                <div class="card border-bottom-primary shadow">
                                    <div class="card-body">
                                        <div class="h1 text-muted text-center mb-4">
                                            <i class="fas fa-university text-primary" style="opacity: 0.8"></i>
                                        </div>
                                        <div class="h4 mb-0 counter-count">{{ number_format($institutions_number - 1, 0) }}</div>
                                        <small class="text-muted text-uppercase font-weight-bold">Institutions</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-3 py-lg-0">
                                <div class="card border-bottom-primary shadow">
                                    <div class="card-body">
                                        <div class="h1 text-muted text-center mb-4">
                                            <i class="fas fa-user-graduate text-primary" style="opacity: 0.8"></i>
                                        </div>
                                        <div class="h4 mb-0 counter-count">{{ number_format($institutions_number - 1, 0) }}</div>
                                        <small class="text-muted text-uppercase font-weight-bold">Students
                                            Enrolled</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-3 py-lg-0">
                                <div class="card border-bottom-primary shadow">
                                    <div class="card-body">
                                        <div class="h1 text-muted text-center mb-4">
                                            <i class="fas fa-chalkboard-teacher text-primary" style="opacity: 0.8"></i>
                                        </div>
                                        <div class="h4 mb-0 counter-count">{{ number_format($institutions_number - 1, 0) }}</div>
                                        <small class="text-muted text-uppercase font-weight-bold">Staff Members</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-3 py-lg-0">
                                <div class="card border-bottom-primary shadow">
                                    <div class="card-body">
                                        <div class="h1 text-muted text-center mb-4">
                                            <i class="fas fa-users-cog text-primary" style="opacity: 0.8"></i>
                                        </div>
                                        <div class="h4 mb-0 counter-count">{{ number_format(\App\User::all()->count(), 0) }}</div>
                                        <small class="text-muted text-uppercase font-weight-bold">Registered
                                            Admins</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @guest
                    <br>
                @endguest

                <section class="showcase">
                    <div class="container-fluid p-0">
                        <h2 id="overview-title" class="text-center text-primary bg-white shadow-sm p-3 mb-5">
                            Overview</h2>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators mx-auto" style="width: 150px">
                                <li data-toggle="tooltip" title="Student Enrollment"
                                    data-target="#carouselExampleIndicators" data-slide-to="0"
                                    class="active bg-gradient-primary" style="width: 30%"></li>
                                <li data-toggle="tooltip" title="Staff Members"
                                    data-target="#carouselExampleIndicators" data-slide-to="1"
                                    class="bg-gradient-primary" style="width: 30%"></li>
                                <li data-toggle="tooltip" title=""
                                    data-target="#carouselExampleIndicators" data-slide-to="2"
                                    class="bg-gradient-primary" style="width: 30%"></li>
                            </ol>
                            <div class="carousel-inner card card-body shadow-sm rounded-0 px-md-5"
                                 style="height: 550px; overflow-y: auto">
                                <div class="carousel-item active">
                                    <div class="row px-5">
                                        <div class="col-lg-5 my-auto px-md-4">
                                            <h3>Student Enrollments</h3>
                                            <hr>
                                            <form action="" method="get" id="enrollments-filter">
                                                <div class="row">
                                                    <div class="col-md">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio"
                                                                   name="student_type"
                                                                   id="students"
                                                                   value="Normal"
                                                                   {{$selected_type == "Normal" ? 'checked' : ''}}  onclick="updateEnrollmentChart()">
                                                            <label class="form-check-label" for="students">
                                                                All Students
                                                            </label>
                                                        </div>
                                                        <div class="form-check my-3">
                                                            <input class="form-check-input" type="radio"
                                                                   name="student_type"
                                                                   id="prospective_graduates"
                                                                   value="Prospective Graduates"
                                                                   {{$selected_type == "Prospective Graduates" ? 'checked' : ''}} onclick="updateEnrollmentChart()">
                                                            <label class="form-check-label" for="prospective_graduates">
                                                                Prospective Graduates
                                                            </label>
                                                        </div>
                                                        <div class="form-check disabled">
                                                            <input class="form-check-input" type="radio"
                                                                   name="student_type"
                                                                   id="graduates"
                                                                   value="Graduates"
                                                                   {{$selected_type == "Graduates" ? 'checked' : ''}} onclick="updateEnrollmentChart()">
                                                            <label class="form-check-label" for="graduates">
                                                                Graduates
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row pt-3">
                                                    <div class="col form-group">
                                                        {!! Form::select('institution', $institutions , $selected_institution , ['class' => 'form-control', 'id' => 'year_enrollment_institutions']) !!}
                                                        {!! Form::label('year_enrollment_institutions', 'University', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('band', $bands , $selected_band , ['class' => 'form-control', 'id' => 'year_enrollment_bands']) !!}
                                                        {!! Form::label('year_enrollment_bands', 'Band', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('college', [] , $selected_college , ['class' => 'form-control', 'id' => 'year_enrollment_colleges']) !!}
                                                        {!! Form::label('year_enrollment_colleges', 'College', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('department', [] , $selected_department , ['class' => 'form-control', 'id' => 'year_enrollment_departments']) !!}
                                                        {!! Form::label('year_enrollment_departments', 'Departments', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('program', $programs , $selected_program , ['class' => 'form-control', 'id' => 'year_enrollment_programs']) !!}
                                                        {!! Form::label('year_enrollment_programs', 'Program', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('education_level', $education_levels , $selected_education_level , ['class' => 'form-control', 'id' => 'year_enrollment_education_levels']) !!}
                                                        {!! Form::label('year_enrollment_education_levels', 'Level', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-7 text-white showcase-img overflow-auto">
                                            <div class="h-100" style="min-width: 500px;">
                                                <div class="row d-none" id="year-enrollment-error">
                                                    <div class="col-12 text-danger text-center my-auto">
                                                        Could not retrieve data.
                                                    </div>
                                                </div>
                                                <div class="row" style="min-height: 500px;">
                                        <span id="year-enrollment-loading"
                                              class="intro-banner-vdo-play-btn pinkBg d-none">
                                            <i class="glyphicon glyphicon-play whiteText" aria-hidden="true"></i>
                                            <span class="ripple pinkBg"></span>
                                            <span class="ripple pinkBg"></span>
                                            <span class="ripple pinkBg"></span>
                                        </span>
                                                    <canvas id="year-enrollment-graph"
                                                            class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row px-5">
                                        <div class="col-lg-5 my-auto px-md-4">
                                            <h3>Staff Members</h3>
                                            <hr>
                                            <form action="" method="get" id="staff-filter">
                                                <div class="form-group row pt-3">
                                                    <div class="col form-group">
                                                        {!! Form::select('institution', $institutions , 0 , ['class' => 'form-control', 'id' => 'staff_institutions']) !!}
                                                        {!! Form::label('staff_institutions', 'University', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('band', $bands , 0 , ['class' => 'form-control', 'id' => 'staff_bands']) !!}
                                                        {!! Form::label('staff_bands', 'Band', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('college', [] , 0 , ['class' => 'form-control', 'id' => 'staff_colleges']) !!}
                                                        {!! Form::label('staff_colleges', 'College', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col form-group d-none">
                                                        {!! Form::select('department', [] , 0 , ['class' => 'form-control', 'id' => 'staff_departments']) !!}
                                                        {!! Form::label('staff_departments', 'Department (for Academic)', ['class' => 'form-control-placeholder']) !!}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-7 text-white showcase-img overflow-auto">
                                            <div class="h-100" style="min-width: 500px;">
                                                <div class="row d-none" id="staff-error">
                                                    <div class="col-12 text-danger text-center my-auto">
                                                        Could not retrieve data.
                                                    </div>
                                                </div>
                                                <div class="row" style="min-height: 500px;">
                                        <span id="staff-loading" class="intro-banner-vdo-play-btn pinkBg d-none">
                                            <i class="glyphicon glyphicon-play whiteText" aria-hidden="true"></i>
                                            <span class="ripple pinkBg"></span>
                                            <span class="ripple pinkBg"></span>
                                            <span class="ripple pinkBg"></span>
                                        </span>
                                                    <canvas id="staff-graph" class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">

                                </div>
                            </div>
                            <a class="carousel-control-prev bg-gradient-primary" style="opacity: 0.85; width: 70px"
                               href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next bg-gradient-primary" style="opacity: 0.85; width: 70px"
                               href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- Testimonials -->
                <section class="testimonials text-center bg-light">
                    <h2 id="people-title" class="text-center text-primary bg-white shadow-sm p-3 mb-5">What people are
                        saying...</h2>
                    <div class="container py-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                                    <img class="img-fluid rounded-circle mb-3" src="{{asset('img/people/person.jpg')}}"
                                         alt="">
                                    <h5>Margaret E.</h5>
                                    <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                                    <img class="img-fluid rounded-circle mb-3" src="{{asset('img/people/person.jpg')}}"
                                         alt="">
                                    <h5>Fred S.</h5>
                                    <p class="font-weight-light mb-0">"Bootstrap is amazing. I've been using it to
                                        create lots of
                                        super nice landing pages."</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                                    <img class="img-fluid rounded-circle mb-3" src="{{asset('img/people/person.jpg')}}"
                                         alt="">
                                    <h5>Sarah W.</h5>
                                    <p class="font-weight-light mb-0">"Thanks so much for making these free resources
                                        available to
                                        us!"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                @guest
                <!-- Call to Action -->
                    <section class="call-to-action text-white text-center" style="margin-bottom: -95px;
                            background: url('{{asset('/img/landing.jpg')}}') no-repeat center center;
                            background-size: cover;">
                        <div class="overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9 mx-auto">
                                    <h2 class="mb-4">Ready to get started? Sign in!</h2>
                                </div>
                                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                                    <div class="form-row mx-auto">
                                        <div class="col-12 col-md-3 mx-auto">
                                            <a href="/login" class="btn btn-block btn-primary mx-auto shadow-sm">Sign
                                                in</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endguest

                @stop
            @section('scripts')
                <script src="{{asset('js/year_enrollment_graph.js')}}"></script>
                <script src="{{asset('js/staff_graph.js')}}"></script>
@endsection
