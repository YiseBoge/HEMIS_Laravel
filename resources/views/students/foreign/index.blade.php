@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foreigner Students</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="foreign/create">Add Student<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <form class="mt-4" action="" method="get">
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
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="program" id="program" onchange="this.form.submit()">
                                        @foreach ($programs as $key => $value)
                                        @if ($value == $selected_program)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$value}}">{{$value}}</option> 
                                        @endif
                                            
                                        @endforeach
                                    </select>
                                    <label for="program" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
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
                                    <label for="level" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                            </div>

                        </form>
                        <div class="row">
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
                                            style="width: 151px;">Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Id
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Gender
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 91px;">Date of Birth
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 91px;">Nationality
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 91px;">Year
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($students) > 0)
                                            @foreach ($students as $student)
                                                <tr role="row" class="odd"
                                                    onclick="window.location='foreign/{{$student->id}}'">
                                                    <td class="pl-4">
                                                        <div class="row">
                                                            <div class="col pt-1">
                                                                <a href="foreign/{{$student->id}}/edit"
                                                                   class="text-primary mr-3"><i class="far fa-edit"></i>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <form class="p-0"
                                                                      action="/student/foreign/{{$student->id}}"
                                                                      method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                            <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>  
                                                    <td>{{$student->general->name}}</td>
                                                    <td>{{$student->general->student_id}}</td>
                                                    <td>{{$student->general->sex}}</td>
                                                    <td>{{$student->general->birth_date}}</td>
                                                    <td>{{$student->nationality}}</td>
                                                    <td>{{$student->department->year_level}}</td>
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
