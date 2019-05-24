@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student Enrollment</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="normal/create">New Entry<i
                                        class="fas fa-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                        <form action="" method="get">
                            <input type="hidden" value="">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="student_type" id="student_type" onchange="this.form.submit()">
                                        @foreach ($student_types as $key => $value)
                                            @if ($value == $selected_student_type)
                                                <option value="{{$value}}" selected>{{$value}}</option>
                                            @else
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endif                                            
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Student Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="college" id="college" onchange="this.form.submit()" >
                                        @foreach ($colleges as $college)
                                            @if ($college->college_name == $selected_college)
                                                <option value="{{$college->college_name}}" selected>{{$college->college_name}}</option>
                                            @else
                                                <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                            @endif
                                            
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        College
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="band" id="band" onchange="this.form.submit()">
                                        @foreach ($bands as $band)
                                            @if ($band->band_name == $selected_band)
                                            <option value="{{$band->band_name}}" selected>{{$band->band_name}}</option>
                                            @else
                                            <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                            @endif
                                            
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Band
                                    </label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">

                                    <select class="form-control" name="program" id="program" onchange="this.form.submit()">
                                        @foreach ($programs as $key => $value)
                                        @if ($value == $selected_program)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$value}}">{{$value}}</option> 
                                        @endif
                                            
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col form-group">

                                    <select class="form-control" name="education_level" id="level" onchange="this.form.submit()">
                                        @foreach ($education_levels as $key => $value)
                                        @if ($key == 'SPECIALIZATION')
                                                <option disabled value="{{$value}}">{{$value}}</option>
                                        @elseif($value == $selected_education_level)
                                                <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                                <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                                <div class="col form-group">

                                    <select class="form-control" name="department" id="department" onchange="this.form.submit()">
                                        @foreach ($departments as $department)
                                            @if ($department->department_name == $selected_department)
                                            <option value="{{$department->department_name}}" selected>{{$department->department_name}}</option>
                                            @else
                                            <option value="{{$department->department_name}}">{{$department->department_name}}</option>
                                            @endif
                                           
                                        @endforeach
                                    </select>
                                    <label for="department" class="form-control-placeholder">
                                        Department
                                    </label>
                                </div>

                            </div>

                        </form>
                            <div class="container w-50">
                                    <canvas id="enrollment" class="text-center" height="20" width="30"></canvas>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>

    <script>
            var url = "{{url('enrollment/student-enrollment-chart?student_type=' . $selected_student_type . '&college=' . $selected_college . '&band=' . $selected_band . '&program=' . $selected_program . '&education_level=' . $selected_education_level . '&department=' . $selected_department )}}";
            var Enrollments = new Array();
            var Years = new Array();
            $(document).ready(function(){
                $.get(url, function(response){
                    Enrollments = response.enrollments
                    Years = response.year_levels
                    alert(response.enrollments);

                    var ctx = document.getElementById('enrollment').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',
    
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
    
@endsection