@extends('layouts.app')

@section('index_content')
    <!-- Masthead -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Welcome to the MoSHE - Higher Education Management Information System</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <div class="form-row mx-auto">
                        <div class="col-12 col-md-3 mx-auto">
                            <a href="/login" class="btn btn-block btn-lg btn-primary mx-auto shadow-sm">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-screen-desktop m-auto text-primary"></i>
                        </div>
                        <h3>{{$institutions_number - 1}}</h3>
                        <p class="lead mb-0">Institutions</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-layers m-auto text-primary"></i>
                        </div>
                        <h3>{{$bands_number - 1}}</h3>
                        <p class="lead mb-0">Bands</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="m-auto icon-basket text-primary"></i>
                        </div>
                        <h3>{{$colleges_number - 1}}</h3>
                        <p class="lead mb-0">Colleges</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="m-auto icon-check text-primary"></i>
                        </div>
                        <h3>{{$departments_number - 1}}</h3>
                        <p class="lead mb-0">Departments</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Showcases -->
    <section class="showcase">
        <div class="container-fluid p-0">
            <h2 class="text-center text-primary">Overview</h2>
            <hr>
            <div class="row p-5">
                <div class="col-lg-5 my-auto px-4">
                    <h2>Student Enrollments</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="student_type" id="students"
                                       value="Normal"
                                       {{$selected_type == "Normal" ? 'checked' : ''}}  onclick="this.form.submit()">
                                <label class="form-check-label" for="students">
                                    All Students
                                </label>
                            </div>
                            <div class="form-check my-3">
                                <input class="form-check-input" type="radio" name="student_type"
                                       id="prospective_graduates" value="Prospective Graduates"
                                       {{$selected_type == "Prospective Graduates" ? 'checked' : ''}} onclick="this.form.submit()">
                                <label class="form-check-label" for="prospective_graduates">
                                    Prospective Graduates
                                </label>
                            </div>
                            <div class="form-check disabled">
                                <input class="form-check-input" type="radio" name="student_type" id="graduates"
                                       value="Graduates"
                                       {{$selected_type == "Graduates" ? 'checked' : ''}} onclick="this.form.submit()">
                                <label class="form-check-label" for="graduates">
                                    Graduates
                                </label>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="container">
                                <div class="col-md-12 custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="male"
                                           id="male" value="male"
                                           {{$selected_sex == "male" || $selected_sex == "all" ? 'checked' : ''}} onclick="this.form.submit()">
                                    <label class="custom-control-label" for="male">Male</label>
                                </div>
                                <br>
                                <div class="col-md-12 custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="female"
                                           id="female" value="female"
                                           {{$selected_sex == "female" || $selected_sex == "all" ? 'checked' : ''}} onclick="this.form.submit()">
                                    <label class="custom-control-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="" method="get">

                        <div class="form-group row pt-3">
                            <div class="col form-group{{in_array('institution', $disabled)?' d-none':''}}">
                                {!! Form::select('institution', $institutions , $selected_institution , ['class' => 'form-control', 'id' => 'institution', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('institution', 'University', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col form-group{{in_array('band', $disabled)?' d-none':''}}">
                                {!! Form::select('band', $bands , $selected_band , ['class' => 'form-control', 'id' => 'band', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('band', 'Band', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col form-group{{in_array('college', $disabled)?' d-none':''}}">
                                {!! Form::select('college', $colleges , $selected_college , ['class' => 'form-control', 'id' => 'college', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('college', 'College', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col form-group{{in_array('department', $disabled)?' d-none':''}}">
                                {!! Form::select('department', $departments , $selected_department , ['class' => 'form-control', 'id' => 'department', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('department', 'Departments', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col form-group{{in_array('program', $disabled)?' d-none':''}}">
                                {!! Form::select('program', $programs , $selected_program , ['class' => 'form-control', 'id' => 'program', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('program', 'Program', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col form-group{{in_array('level', $disabled)?' d-none':''}}">
                                {!! Form::select('education_level', $education_levels , $selected_education_level , ['class' => 'form-control', 'id' => 'education_level', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('education_level', 'Level', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-7 text-white showcase-img">
                    <div class="card shadow card-body border-right-primary">
                        <canvas id="year-enrollment" class="chartjs-render-monitor" style="min-height: 40vh"></canvas>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5 text-primary">What people are saying...</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{asset('img/logo.png')}}" alt="">
                        <h5>Margaret E.</h5>
                        <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{asset('img/logo.png')}}" alt="">
                        <h5>Fred S.</h5>
                        <p class="font-weight-light mb-0">"Bootstrap is amazing. I've been using it to create lots of
                            super nice landing pages."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{asset('img/logo.png')}}" alt="">
                        <h5>Sarah W.</h5>
                        <p class="font-weight-light mb-0">"Thanks so much for making these free resources available to
                            us!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var url = "/student-enrollment-chart?student_type={{$selected_type}}&sex={{$selected_sex}}&institution={{$selected_institution}}&program={{$selected_program}}&college={{$selected_college}}&band={{$selected_band}}&education_level={{$selected_education_level}}&department={{$selected_department}}";
        var Enrollments = [];
        var Years = [];
        $(document).ready(function () {
            $.get(url, function (response) {
                Years = response.year_levels;
                Enrollments = response.enrollments;

                var ctx = document.getElementById('year-enrollment').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: Years,
                        datasets: [{
                            label: 'Enrollment',
                            data: Enrollments,
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2
                        }]
                    },

                    // Configuration options go here
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Year Level'
                                },
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Enrollment'
                                },
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    beginAtZero: true

                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }

                    },

                });
            });
        });
    </script>
    <script>
        var url2 = "age-enrollment-chart";
        var Enrollments = [];
        var Ages = [];
        $(document).ready(function () {
            $.get(url2, function (response) {
                Ages = response.ages;
                Enrollments = response.enrollments;

                var ctx = document.getElementById('age-enrollment').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: Ages,
                        datasets: [{
                            label: 'Enrollment',
                            data: Enrollments,
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 1)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2
                        }]
                    },

                    // Configuration options go here
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    beginAtZero: true

                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }

                    },

                });
            });
        });
    </script>

    <script>
        var url3 = "{{url('specialNeeds-enrollment-chart')}}";
        var specialNeedsTypes = [];
        var numberOfMale = [];
        var numberOfFemale = [];
        $(document).ready(function () {
            $.get(url3, function (response) {
                specialNeedsTypes = response.types;
                numberOfMale = response.male;
                numberOfFemale = response.female;


                var ctx = document.getElementById('specialNeeds-enrollment').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'pie',

                    // The data for our dataset
                    data: {
                        labels: specialNeedsTypes,
                        datasets: [{
                            label: 'SpecialNeeds',
                            data: numberOfMale,
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2
                        }]
                    },

                    // Configuration options go here
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Year Level'
                                },
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    beginAtZero: true

                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,

                        }
                    },

                });
            });
        });
    </script>


@endSection
