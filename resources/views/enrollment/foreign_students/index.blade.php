@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foreign Students</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="foreign-students/create">New Entry<i
                                        class="fas fa-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                        <form action="" method="get">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="college" id="college"
                                            onchange="this.form.submit()">
                                        @foreach ($colleges as $college)
                                            <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="college" class="form-control-placeholder">
                                        College
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="band" id="band" onchange="this.form.submit()">
                                        @foreach ($bands as $band)
                                            <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="band" class="form-control-placeholder">
                                        Band
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="education_level" id="education_level"
                                            onchange="this.form.submit()">
                                        @foreach ($education_levels as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="education_level" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">

                                    <select class="form-control" name="program" id="program"
                                            onchange="this.form.submit()">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="program" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col form-group">

                                    <select class="form-control" name="reason" id="reason"
                                            onchange="this.form.submit()">
                                        @foreach ($reasons as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="reason" class="form-control-placeholder">
                                        Reason
                                    </label>
                                </div>
                                <div class="col form-group">

                                    <select class="form-control" name="year_level" id="year_level"
                                            onchange="this.form.submit()">
                                        @foreach ($year_levels as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="year_level" class="form-control-placeholder">
                                        Year Level
                                    </label>
                                </div>

                            </div>
                        </form>
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
                                                    <td>{{$enrollment->number_of_male_students}}</td>
                                                    <td>{{$enrollment->number_of_female_students}}</td>
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
