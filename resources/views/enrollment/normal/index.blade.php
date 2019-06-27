@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student Enrollment</h6>
            </div>
            <div class="card-body">
                @if(!Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/enrollment/normal-chart">Generate
                                Report<i
                                        class="fas fa-download text-white-50 fa-sm ml-2"></i></a>
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/enrollment/normal/create">New
                                Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif
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
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="student_type" id="student_type"
                                    onchange="this.form.submit()">
                                @foreach ($student_types as $key => $value)
                                    @if ($value == $selected_student_type)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="student_type" class="form-control-placeholder">
                                Student Type
                            </label>
                        </div>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="program" id="program"
                                    onchange="this.form.submit()">
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

                        <div class="col-md-4 form-group">
                            <select class="form-control" name="education_level" id="level"
                                    onchange="this.form.submit()">
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
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead>
                        <tr role="row">
                            @if(Auth::user()->hasRole('College Super Admin'))
                                <th style="min-width: 50px; width: 50px">
                                    <form action="normal/0/approve" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="approveAll">
                                        <input type="hidden" name="department"
                                               value="{{$selected_department}}">
                                        <input type="hidden" name="student_type"
                                               value="{{$selected_student_type}}">
                                        <input type="hidden" name="program" value="{{$selected_program}}">
                                        <input type="hidden" name="education_level"
                                               value="{{$selected_education_level}}">
                                        <button type="submit"
                                                class="form-control btn btn-sm btn-link text-primary text-lg p-1">
                                            <u>Approve All</u>
                                        </button>
                                    </form>
                                </th>
                            @else
                                <th style="min-width: 50px; width: 50px"></th>
                            @endif
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending"
                                style="width: 151px;">Year
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
                            @if(!Auth::user()->hasRole('College Super Admin'))
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="width: 99px;">Approval Status
                                </th>
                            @endif

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($enrollments) > 0)
                            @foreach ($enrollments as $enrollment)
                                <tr role="row" class="odd"
                                    onclick="window.location='normal/{{$enrollment->id}}'">
                                    @if(Auth::user()->hasRole('College Super Admin'))
                                        <td>
                                            <form action="normal/{{$enrollment->id}}/approve"
                                                  method="POST">
                                                @csrf
                                                @if($enrollment->approval_status == "Approved")
                                                    <input type="hidden" name="action"
                                                           value="disapprove">
                                                    <button type="submit"
                                                            class="form-control btn btn-sm btn-link text-danger p-0">
                                                        <u>Disapprove</u>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit"
                                                            class="form-control btn btn-sm btn-link text-primary p-0">
                                                        <u>Approve</u>
                                                    </button>
                                                @endif

                                            </form>
                                        </td>
                                    @else
                                        @if($enrollment->approval_status == "Approved")
                                            <td></td>
                                        @else
                                            <td class="pl-4">
                                                <div class="row">
                                                    <div class="col pt-1">
                                                        <a href="normal/{{$enrollment->id}}/edit"
                                                           class="text-primary mr-3"><i
                                                                    class="far fa-edit"></i> </a>
                                                    </div>
                                                    <div class="col">
                                                        <form class="p-0"
                                                              action="/enrollment/normal/{{$enrollment->id}}"
                                                              method="POST">
                                                            @csrf
                                                            <input type="hidden" name="_method"
                                                                   value="DELETE">
                                                            <button type="submit"
                                                                    class="form-control form-control-plaintext text-danger p-0">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    @endif

                                    <td>{{$enrollment->department->year_level}}</td>
                                    <td>{{$enrollment->male_students_number}}</td>
                                    <td>{{$enrollment->female_students_number}}</td>
                                    @if(!Auth::user()->hasRole('College Super Admin'))
                                        @if($enrollment->approval_status == "Approved")
                                            <td class="text-success">{{$enrollment->approval_status}}</td>
                                        @elseif($enrollment->approval_status == "Pending")
                                            <td class="text-warning">{{$enrollment->approval_status}}</td>
                                        @else
                                            <td class="text-danger">{{$enrollment->approval_status}}</td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
