@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row my-3">
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of Institutions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$institutions_number}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of Colleges
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$colleges_number}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of Bands
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$bands_number}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Number of Departments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$departments_number}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row my-5">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header text-primary font-weight-bold">Student Enrollment By Year</div>

                    <div class="card-body">
                            <form action="" method="get">
                                    <input type="hidden" value="">
                                    <div class="form-group row pt-3">
                                        <div class="col form-group">
                                            {!! Form::select('institution', $institutions , $selected_institution , ['class' => 'form-control', 'id' => 'institution', 'onchange' => 'this.form.submit()', in_array('institution', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('institution', 'University', ['class' => 'form-control-placeholder']) !!}
                                        </div>
                                        <div class="col form-group">
                                            {!! Form::select('band', $bands , $selected_band , ['class' => 'form-control', 'id' => 'band', 'onchange' => 'this.form.submit()', in_array('band', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('band', 'Band', ['class' => 'form-control-placeholder']) !!}
                                        </div>
                                        <div class="col form-group">
                                            {!! Form::select('college', $colleges , $selected_college , ['class' => 'form-control', 'id' => 'college', 'onchange' => 'this.form.submit()', in_array('college', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('college', 'College', ['class' => 'form-control-placeholder']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row pt-3">
                                        <div class="col form-group">
                                            {!! Form::select('program', $programs , $selected_program , ['class' => 'form-control', 'id' => 'program', 'onchange' => 'this.form.submit()', in_array('program', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('program', 'Program', ['class' => 'form-control-placeholder']) !!}
                                        </div>
        
                                        <div class="col form-group">
                                            {!! Form::select('education_level', $education_levels , $selected_education_level , ['class' => 'form-control', 'id' => 'education_level', 'onchange' => 'this.form.submit()', in_array('level', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('education_level', 'Level', ['class' => 'form-control-placeholder']) !!}
                                        </div>
                                        <div class="col form-group">
                                            {!! Form::select('department', $departments , $selected_department , ['class' => 'form-control', 'id' => 'department', 'onchange' => 'this.form.submit()', in_array('department', $disabled)?'disabled':'']) !!}
                                            {!! Form::label('department', 'Departments', ['class' => 'form-control-placeholder']) !!}
                                        </div>
        
                                    </div>
        
                                
                        <div class="row my-3">
                            <div class="col-md-9">
                                <div class="container">
                                    <canvas id="year-enrollment" class="chartjs-render-monitor" height="350" width="600"></canvas>
                                </div>

                                <div class="container text-center">
                                    <div class="row mt-3">
                                        <div class="col-md-6 custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="male" id="male" value="male" {{$selected_sex == "male" || $selected_sex == "all" ? 'checked' : ''}} onclick="this.form.submit()">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="col-md-6 custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="female" id="female" value="female" {{$selected_sex == "female" || $selected_sex == "all" ? 'checked' : ''}} onclick="this.form.submit()">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-md-3">
                                    <div class="form-check my-3">
                                    <input class="form-check-input" type="radio" name="student_type" id="students" value="Normal" {{$selected_type == "Normal" ? 'checked' : ''}}  onclick="this.form.submit()">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Students
                                    </label>
                                    </div>
                                    <div class="form-check my-3">
                                    <input class="form-check-input" type="radio" name="student_type" id="prospective_graduates" value="Prospective Graduates" {{$selected_type == "Prospective Graduates" ? 'checked' : ''}} onclick="this.form.submit()">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Prospective Graduates
                                    </label>
                                    </div>
                                    <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="student_type" id="graduates" value="Graduates" {{$selected_type == "Graduates" ? 'checked' : ''}} onclick="this.form.submit()">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Graduates
                                    </label>
                                    </div>
                            </div>
                                
                        </div>

                    </form>
                    </div>

                </div>
            </div>           
        </div>
        {{-- <div class="row">
            <div class="col-md-5">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Student Enrollment By Age</div>

                    <div class="card-body">
                        <canvas id="age-enrollment" height="300" width="600"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>


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
