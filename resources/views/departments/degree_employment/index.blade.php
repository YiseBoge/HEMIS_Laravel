@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Students Accessing Degree-relevant Employment Within 12
                    Months After Graduation </h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row">
                        <div class="col text-right">
                                <form action="degree-relevant-employment/0/approve" method="POST">
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
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                            href="/student/degree-relevant-employment/create">New Entry<i
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
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th style="min-width: 75px; width: 75px"></th>
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending"
                                style="min-width: 151px;">Department
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                                style="min-width: 46px;">Number of Male Students
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 99px;">Number of Female Students
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 99px;">Approval Status
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($employments) > 0)
                            @foreach ($employments as $employment)
                                <tr role="row" class="odd"
                                    onclick="window.location='/student/degree-relevant-employment/{{$employment->id}}'">
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($employment->approval_status == "Pending")
                                                <form action="degree-relevant-employment/{{$employment->id}}/approve" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80" data-toggle="tooltip" title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif                                                
                                        @else
                                            @if($employment->approval_status != "Approved")
                                                <div class="row px-1">
                                                    <div class="col">
                                                        <form class="p-0"
                                                            action="/student/degree-relevant-employment/{{$employment->id}}/edit"
                                                            method="GET">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-circle text-white btn-sm" style="opacity:0.80" data-toggle="tooltip" title="Edit">
                                                                    <i class="fas fa-pencil-alt fa-sm" style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col">
                                                        <form class="p-0"
                                                                action="/student/degree-relevant-employment/{{$employment->id}}"
                                                                method="POST">
                                                            @csrf
                                                            <input type="hidden" name="_method"
                                                                    value="DELETE">
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-circle text-white btn-sm" style="opacity:0.80" data-toggle="tooltip" title="Delete">
                                                                <i class="fas fa-trash fa-sm" style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div> 
                                            @endif                                                           
                                        @endif
                                    </td>
                                    <td>{{$employment->department->departmentName->department_name}}</td>
                                    <td>{{$employment->male_students_number}}</td>
                                    <td>{{$employment->female_students_number}}</td>
                                    @if($employment->approval_status == "Approved")
                                        <td class="text-success"><i class="fas fa-check"></i> {{$employment->approval_status}}</td>
                                    @elseif($employment->approval_status == "Pending")
                                        <td class="text-warning"> <i class="far fa-clock"></i></i> {{$employment->approval_status}}</td>
                                    @else
                                        <td class="text-danger"><i class="fas fa-times"></i> {{$employment->approval_status}}</td>
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
