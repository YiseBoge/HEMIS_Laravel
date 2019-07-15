@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upgrading Staff</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                                <form action="upgrading-staff/0/approve" method="POST">
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
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="upgrading-staff/create">New
                                Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif
                <div class="row">
                    {!! Form::open(['action' => 'Department\UpgradingStaffController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    @if(Auth::user()->hasRole('College Super Admin'))
                        <div class="form-row">
                            <div class="col-md form-group px-3">
                                {!! Form::select('department', $departments , $selected_department , ['class' => 'form-control', 'id' => 'department', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('department', 'Department', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="col-md-6 px-3 py-md-1 col">
                            <div class="form-group">
                                {!! Form::select('study_place', \App\Models\Department\UpgradingStaff::getEnum('StudyPlaces') , $selected_place , ['class' => 'form-control', 'id' => 'add_study_place', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('add_study_place', 'Study Place', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <table class="table table-bordered dataTable table-striped table-hover"
                               id="dataTable"
                               width="100%"
                               cellspacing="0" role="grid" aria-describedby="dataTable_info"
                               style="width: 100%;">

                            <thead>
                            <tr role="row">
                                <th style="min-width: 50px; width: 50px"></th>

                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                >Education Level
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                >Male
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                >Female
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="min-width: 99px;">Approval Status
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($upgrading_staffs as $upgrading_staff)
                                <tr>
                                    <td class="text-center">
                                            @if(Auth::user()->hasRole('College Super Admin'))
                                                @if($upgrading_staff->approval_status == "Pending")
                                                    <form action="upgrading-staff/{{$upgrading_staff->id}}/approve"
                                                            method="POST">
                                                        @csrf
                                                        <input type="hidden" name="action" value="disapprove">
                                                        <button type="submit" style="opacity:0.80"
                                                                data-toggle="tooltip" title="Disapprove"
                                                                class="btn btn-danger btn-circle text-white btn-sm">
                                                            <i class="fas fa-times" style="opacity:0.75"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                @if($upgrading_staff->approval_status != "Approved")
                                                    <div class="row px-1">
                                                        <div class="col px-0">
                                                            <form class="p-0"
                                                                    action="upgrading-staff/{{$upgrading_staff->id}}/edit"
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
                                                                    action="upgrading-staff/{{$upgrading_staff->id}}"
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

                                    <td>{{ $upgrading_staff->education_level}}</td>
                                    <td>{{ $upgrading_staff->male_number }}</td>
                                    <td>{{ $upgrading_staff->female_number }}</td>
                                    @if($upgrading_staff->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check"></i> {{$upgrading_staff->approval_status}}
                                        </td>
                                    @elseif($upgrading_staff->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$upgrading_staff->approval_status}}
                                        </td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$upgrading_staff->approval_status}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you wish to delete?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection