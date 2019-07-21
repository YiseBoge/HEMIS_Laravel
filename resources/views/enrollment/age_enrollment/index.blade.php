@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Age Enrollment Data</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row">
                        <div class="col text-right">
                                <form action="age-enrollment/0/approve" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approveAll">
                                    <input type="hidden" name="department"
                                            value="{{$selected_department}}">
                                    <button type="submit"
                                            class="btn btn-sm btn-primary shadow-sm">
                                        Approve All Pending in Selected Department<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                    </button>
                                </form>
                        </div>
                    </div>                           
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/enrollment/age-enrollment/create">New
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
                        <div class="col-md-6 form-group">
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

                        <div class="col-md-6 form-group">
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
                            <th style="min-width: 50px; width: 50px"></th>
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending" width="15"
                                style="width: 15%;">Age Range
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                            >Male(Aggregate number)
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Female(Aggregate number)
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 99px;">Approval Status
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($enrollment_info) > 0)
                            @foreach ($enrollment_info as $info)
                                <tr role="row" class="odd"
                                    onclick="window.location='age-enrollment/{{$info->id}}'">
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($info->approval_status == "Pending")
                                                <form action="age-enrollment/{{$info->id}}/approve" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80" data-toggle="tooltip" title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif                                                
                                        @else
                                            @if($info->approval_status != "Approved")
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="/enrollment/age-enrollment/{{$info->id}}/edit"
                                                              method="GET">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-circle text-white btn-sm mx-0"
                                                                    style="opacity:0.80"
                                                                    data-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-pencil-alt fa-sm"
                                                                   style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="/enrollment/age-enrollment/{{$info->id}}"
                                                              method="POST">
                                                            @csrf
                                                            <input type="hidden" name="_method"
                                                                   value="DELETE">
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-circle text-white btn-sm mx-0"
                                                                    style="opacity:0.80"
                                                                    data-toggle="tooltip" title="Delete">
                                                                <i class="fas fa-trash fa-sm"
                                                                   style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif                                                           
                                        @endif
                                    </td>

                                    <td class="sorting_1">{{$info->age}}</td>
                                    <td>{{$info->male_students_number}}</td>
                                    <td>{{$info->female_students_number}}</td>
                                    @if($info->approval_status == "Approved")
                                        <td class="text-success"><i class="fas fa-check"></i> {{$info->approval_status}}</td>
                                    @elseif($info->approval_status == "Pending")
                                        <td class="text-warning"> <i class="far fa-clock"></i></i> {{$info->approval_status}}</td>
                                    @else
                                        <td class="text-danger"><i class="fas fa-times"></i> {{$info->approval_status}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @else

                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($page_name == 'institution.admin_and_non_academic_staff.edit')
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <form class="" action="/staff/academic" method="POST">
                                @csrf
                                <h3 class="font-weight-bold text-primary">Edit Admin(Non Academic) Staff Member
                                    Info</h3>
                                <div class="row">
                                </div>
                                <div class="modal-body row p-2">
                                    <div class="col-12">
                                        <fieldset class="card shadow h-100">
                                            <div class="card-header text-primary">
                                                Aggregate Information
                                            </div>

                                            <div class="form-row pt-3">
                                                <div class="col-md form-group">

                                                    <select class="form-control" id="empType" name="employment_type">
                                                        @foreach ($education_levels as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="empType" class="form-control-placeholder pt-3">Employment
                                                        Type</label>
                                                </div>
                                            </div>

                                            <div class="card-body px-4">
                                                <div class="form-row ptt-1">
                                                    <div class="col form-group">
                                                        <input type="text" id="no_of_females" name="number_of_females"
                                                               class="form-control" required>
                                                        <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                                    </div>

                                                    <div class="col form-group">
                                                        <input type="text" id="no_of_males" name="number_of_males"
                                                               class="form-control" required>
                                                        <label class="form-control-placeholder" for="no_of_males">Males(Aggregate)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        @endif

    </div>

@endsection
