@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cost Sharing</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row">
                        <div class="col text-right">
                            <form action="cost-sharing/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <input type="hidden" name="department"
                                       value="{{$selected_department}}">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm">
                                    Approve All Pending in Selected Department<i
                                            class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/student/cost-sharing/create">New
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
                                aria-label="Name: activate to sort column descending"
                                style="min-width: 151px;">Name
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                                style="min-width: 46px;">Id
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 99px;">Gender
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                style="min-width: 91px;">Field of Study
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                style="min-width: 91px;">TIN Number
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                style="min-width: 91px;">Receipt Number
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                style="min-width: 91px;">Total Unpaid Amount
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 95px;">Approval Status
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($costSharings) > 0)
                            @foreach ($costSharings as $costSharing)
                                <tr role="row" class="odd"
                                    onclick="window.location='cost-sharing/{{$costSharing->id}}'">
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($costSharing->approval_status == "Pending")
                                                <form action="normal/{{$costSharing->id}}/approve" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80" data-toggle="tooltip"
                                                            title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if($costSharing->approval_status != "Approved")
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="/student/cost-sharing/{{$costSharing->id}}/edit"
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
                                                        <button type="submit"
                                                                class="btn btn-danger btn-circle text-white btn-sm mx-0 deleter"
                                                                style="opacity:0.80" data-id="{{$costSharing->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$costSharing->name}}</td>
                                    <td>{{$costSharing->student_id}}</td>
                                    <td>{{$costSharing->sex}}</td>
                                    <td>{{$costSharing->field_of_study}}</td>
                                    <td>{{$costSharing->tin_number}}</td>
                                    <td>{{$costSharing->receipt_number}}</td>
                                    <td>{{$costSharing->unpaid_amount}}</td>
                                    @if($costSharing->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check"></i> {{$costSharing->approval_status}}</td>
                                    @elseif($costSharing->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$costSharing->approval_status}}</td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$costSharing->approval_status}}</td>
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
