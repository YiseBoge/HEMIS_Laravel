@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Disabled Students</h6>
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

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="student_type" id="student_type" onchange="this.form.submit()">
                                        @foreach ($student_types as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Student Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="college" id="college" onchange="this.form.submit()" >
                                        @foreach ($colleges as $college)
                                            <option value="{{$college->id}}">{{$college->college_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        College
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="band" id="band" onchange="this.form.submit()">
                                        @foreach ($bands as $band)
                                            <option value="{{$band->id}}">{{$band->band_name}}</option>
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
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col form-group">

                                    <select class="form-control" name="education_level" id="level" onchange="this.form.submit()">
                                        @foreach ($education_levels as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                                <div class="col form-group">

                                    <select class="form-control" name="year_level" id="year_level" onchange="this.form.submit()">
                                        @foreach ($year_levels as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="dormitory_service_type" class="form-control-placeholder">
                                        Year Level
                                    </label>
                                </div>

                            </div>

                        </form>


                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="normal/">Reload</a>
                                </div>
                            </div>
                            <hr>                        
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable table-striped table-hover" id="dataTable" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 151px;">Department
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Male Students
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Students
                                        </th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($enrollments) > 0)
                                            @foreach ($enrollments as $enrollment)
                                                <tr role="row" class="odd" onclick="window.location='normal/{{$enrollment->id}}'">
                                                    <td class="pl-4">
                                                        <div class="row">
                                                            <div class="col pt-1">
                                                                <a href="normal/{{$enrollment->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> </a>
                                                            </div>
                                                            <div class="col">
                                                                <form class="p-0" action="/enrollment/normal/{{$enrollment->id}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                            <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>  
                                                    <td>{{$enrollment->department->departmentName->department_name}}</td>
                                                    <td>{{$enrollment->male_students_number}}</td>
                                                    <td>{{$enrollment->female_students_number}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
