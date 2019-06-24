@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Staff Attrition</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/staff/attrition/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <form class="mt-4" action="" method="get">
                    <div class="form-group row pt-3">
                        @if(Auth::user()->hasRole('College Admin'))
                            <div class="col-md-6 form-group">
                                <select class="form-control" name="type" id="type"
                                        onchange="this.form.submit()">
                                    @foreach ($staff_types as $type)
                                        @if ($type == $selected_type)
                                            <option value="{{$type}}" selected>{{$type}}</option>
                                        @else
                                            <option value="{{$type}}">{{$type}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="type" class="form-control-placeholder">
                                    Staff Type
                                </label>
                            </div>
                        @endif
                        <div class="col-md-6 form-group">
                            <select class="form-control" name="case" id="case" onchange="this.form.submit()">
                                @foreach ($cases as $key => $value)
                                    @if ($value == $selected_case)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="case" class="form-control-placeholder">
                                Case
                            </label>
                        </div>

                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table border dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead>
                        <tr role="row">

                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending"
                                style="width: 151px;">Staff Member
                            </th>
                            <th style="min-width: 50px; width: 50px"></th>

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($attritions) > 0)
                            @foreach ($attritions as $attrition)
                                <tr role="row" class="odd"
                                    onclick="window.location='attrition/{{$attrition->id}}'">
                                    <td>{{$attrition->staff->name}}</td>
                                    <td class="pl-4">
                                        <div class="row">
                                            <div class="col">
                                                <form class="p-0"
                                                      action="/staff/attrition/{{$attrition->id}}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit"
                                                            class="form-control form-control-plaintext text-danger p-0">
                                                        <i class="far fa-trash-alt"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($page_name == 'staff.attrition.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/staff/attrition" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body pt-4">
                        @if(Auth::user()->hasRole('College Admin'))
                            <form action="" method="GET">
                                <div class="form-group row pt-3">
                                    <div class="col form-group">
                                        <select class="form-control" name="type" id="type"
                                                onchange="this.form.submit()">
                                            @foreach ($staff_types as $type)
                                                @if ($type == $selected_type)
                                                    <option value="{{$type}}" selected>{{$type}}</option>
                                                @else
                                                    <option value="{{$type}}">{{$type}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="case" class="form-control-placeholder">
                                            Staff Type
                                        </label>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <form action="/staff/attrition" method="POST">
                            @csrf
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="case" id="case">
                                        @foreach ($cases as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="case" class="form-control-placeholder">
                                        Case
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="staff" id="staff">
                                        @foreach ($staffs as $staff)
                                            <option value="{{$staff->general->id}}">{{$staff->general->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="staff" class="form-control-placeholder">
                                        Staff Member
                                    </label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>

                        </form>
                    </div>


                </div>

            </div>
        </div>
    @endif

@endsection
