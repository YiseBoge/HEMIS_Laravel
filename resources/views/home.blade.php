@extends('layouts.app')

@section('content')

    <div class="container-fluid p-0 px-md-3">
        @if (Auth::user()->hasRole('Super Admin'))
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
        @else
            <h1 class="text-primary">
                @if (Auth::user()->hasRole('Department Admin'))
                    {{ Auth::user()->departmentName }}
                @elseif (Auth::user()->hasAnyRole(['College Admin', 'College Super Admin']))
                    {{ Auth::user()->collegeName }}
                @elseif (Auth::user()->hasRole('University Admin'))
                    {{ Auth::user()->institution()->institutionName }}
                @endif
            </h1>
            <hr>
            <div class="row my-3">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{$titles[0]}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$data[0]}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               {{$titles[1]}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$data[1]}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{$titles[2]}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$data[2]}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{$titles[3]}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$data[3]}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row my-5">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header text-primary font-weight-bold">Student Enrollment By Year</div>

                <!--<div class="card-body">
                            @if (session('status'))
                    <div class="alert alert-success" role="alert">
{{ session('status') }}
                            </div>
@endif

                        You are logged in!
                    </div>-->
                    <div class="card-body">
                        <canvas id="year-enrollment" class="chartjs-render-monitor" height="280" width="600"></canvas>
                    </div>

                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow h-100">
                    <div class="card-header text-primary font-weight-bold">Student Enrollment By Age</div>

                <!--<div class="card-body">
                            @if (session('status'))
                    <div class="alert alert-success" role="alert">
{{ session('status') }}
                            </div>
@endif

                        You are logged in!
                    </div>-->
                    <div class="card-body">
                        <canvas id="age-enrollment" height="280" width="600"></canvas>
                    </div>


                </div>
            </div>


            {{--            <div class="col-md-5 m-4">--}}
            {{--                <div class="card shadow h-100">--}}
            {{--                    <div class="card-header text-primary font-weight-bold">Special Needs Enrollment</div>--}}

            {{--                <!--<div class="card-body">--}}
            {{--                            @if (session('status'))--}}
            {{--                    <div class="alert alert-success" role="alert">--}}
            {{--{{ session('status') }}--}}
            {{--                            </div>--}}
            {{--@endif--}}

            {{--                        You are logged in!--}}
            {{--                    </div>-->--}}
            {{--                    <div class="card-body">--}}
            {{--                        <canvas id="specialNeeds-enrollment" class="chartjs-render-monitor" height="400"--}}
            {{--                                width="600"></canvas>--}}
            {{--                    </div>--}}


            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>

@stop
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" defer></script>

    <script>
        var url = "{{url('home/student-enrollment-chart')}}";
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
        var url2 = "{{url('home/age-enrollment-chart')}}";
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
        var url3 = "{{url('home/specialNeeds-enrollment-chart')}}";
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
@endsection




{{-- var lineChartData = {
    labels:,
    datasets: [{
        label: 'Male',
        borderColor: window.chartColors.red,
        backgroundColor: window.chartColors.red,
        fill: false,
        data: numberOfMale,
        yAxisID: 'y-axis-1',
    }, {
        label: 'Female',
        borderColor: window.chartColors.blue,
        backgroundColor: window.chartColors.blue,
        fill: false,
        data: numberOfFemale,
        yAxisID: 'y-axis-2'
    }]
}; --}}