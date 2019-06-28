@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Specializing Students</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="specializing-students/create">New Entry<i
                                        class="fas fa-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                            <form action="" method="get">
                                    @if(Auth::user()->hasRole('College Super Admin'))
                                        <div class="form-group row pt-3">
                                            <div class="col-md form-group">
                                                <select class="form-control" name="department" id="department"
                                                        onchange="this.form.submit()">
                                                    @foreach ($departments as $department)
                                                        @if ($department->id == $selected_department)
                                                            <option value="{{$department->id}}"
                                                                    selected>{{$department->department_name}}</option>
                                                        @else
                                                            <option value="{{$department->id}}">{{$department->department_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label for="department" class="form-control-placeholder">
                                                    Department
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row pt-3">
                                        <div class="col-md-4 form-group">
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
                                        <div class="col-md-4 form-group">
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

                                        <div class="col-md-4 form-group">
                                                <select class="form-control" name="specialization_type" id="specialization_type"
                                                        onchange="this.form.submit()">
                                                    @foreach ($specialization_types as $key => $value)
                                                    @if ($value == $selected_specialization)
                                                    <option value="{{$value}}" selected>{{$value}}</option>
                                                    @else
                                                    <option value="{{$value}}">{{$value}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="specialization_type" class="form-control-placeholder">
                                                    Specialization Type
                                                </label>
                                            </div>
                                    </div>
        
                                </form>

                    
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
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 151px;">Field of Specialization
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
                                                    <td>{{$enrollment->field_of_specialization}}</td>
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
