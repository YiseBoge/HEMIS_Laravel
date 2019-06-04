@extends('layouts.app')

@section('content')
    @if (Auth::user()->hasRole('Super Admin'))

    @else
    <div class="container-fluid">
            <h1 class="text-primary">{{$name}}</h1>
            <div class="row my-3">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Number of Campuses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                4
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
                                6
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Number of Institutes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                2
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Number of Schools
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                1
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <canvas id="age-enrollment" height="400" width="600"></canvas>
                        </div>

                       
                        
                    </div>
                </div>



                <div class="col-md-5 m-4">                
                    <div class="card shadow h-100">
                        <div class="card-header text-primary font-weight-bold">Special Needs Enrollment</div>
    
                        <!--<div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
    
                            You are logged in!
                        </div>-->
                        <div class="card-body">
                            <canvas id="specialNeeds-enrollment"  class="chartjs-render-monitor" height="400" width="600"></canvas>
                        </div>

                       
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous"></script>
    <script>
        var url = "{{url('home/student-enrollment-chart')}}";
        var Enrollments = new Array();
        var Years = new Array();
        $(document).ready(function(){
            $.get(url, function(response){
                Years = response.year_levels
                Enrollments = response.enrollments

                var ctx = document.getElementById('year-enrollment').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: Years,
                        datasets: [{
                            label: 'Enrollment',                   
                            data: Enrollments
                        }]
                    },

                    // Configuration options go here
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    },
                   
                });
            });
        });
    </script>
    <script>
        var url2 = "{{url('home/age-enrollment-chart')}}";
        var Enrollments = new Array();
        var Ages = new Array();
        $(document).ready(function(){
            $.get(url2, function(response){
                Ages = response.ages
                Enrollments = response.enrollments

                var ctx = document.getElementById('age-enrollment').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: Ages,
                        datasets: [{
                            label: 'Enrollment',                   
                            data: Enrollments
                        }]
                    },

                    // Configuration options go here
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    },
                    
                });
            });
        });
    </script>

<script>
    var url3 = "{{url('home/specialNeeds-enrollment-chart')}}";
    var specialNeedsTypes = new Array();
    var numberOfMale = new Array();
    var numberOfFemale = new Array();
    $(document).ready(function(){
        $.get(url3, function(response){
            specialNeedsTypes = response.types
            numberOfMale = response.male
            numberOfFemale = response.female
            
            
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
                        backgroundColor: [ 'red' , 'purple' , 'green'  ],
                        // backgroundColor: [ red , blue , green]
                    }]
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
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