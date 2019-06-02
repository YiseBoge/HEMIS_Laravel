@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Technical Staff</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-1 m-3 text-center">
                        <a href="/staff/technical-staff/create" class="btn btn-outline-primary btn-sm mb-0">
                            Add<i class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <form action="" method="get">
                    <div class="form-group row pt-3">
                        <div class="col form-group">
                            <select class="form-control" name="band" id="band" onchange="this.form.submit()">
                                @foreach ($bands as $band)
                                @if ($band->band_name == $selected_band)
                                <option value="{{$band->band_name}}" selected>{{$band->band_name}}</option>
                                @else
                                <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                @endif
                                    
                                @endforeach
                            </select>
                            <label for="band" class="form-control-placeholder">
                                Band
                            </label>
                        </div>
                        <div class="col form-group">
                            <select class="form-control" name="college" id="college" onchange="this.form.submit()">
                                @foreach ($colleges as $college)
                                @if ($college->college_name == $selected_college)
                                <option value="{{$college->college_name}}" selected>{{$college->college_name}}</option>
                                @else
                                <option value="{{$college->college_name}}">{{$college->college_name}}</option>
                                @endif
                                    
                                @endforeach
                            </select>
                            <label for="college" class="form-control-placeholder">
                                College
                            </label>
                        </div>
                        <div class="col form-group">
                            <select class="form-control" name="level" id="level" onchange="this.form.submit()">
                                @foreach ($levels as $key => $value)
                                @if ($value == $selected_level)
                                <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
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
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable table-striped table-hover"
                                           id="dataTable"
                                           width="100%"
                                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                           style="width: 100%;">

                                        <thead>
                                        <tr role="row">
                                            <th style="min-width: 50px; width: 50px"></th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                            >College
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Number of Male Staff Members
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Number of Female Staff Members
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($staffs as $staff)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $staff->college->collegeName->college_name }}</td>
                                                <td>{{ $staff->male_staff_number }}</td>
                                                <td>{{ $staff->female_staff_number }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'college.technical_staff.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form class="pb-5" action="/staff/technical-staff" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/staff/technical-staff" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>


                    <div class="modal-body pt-4">
                   
                        <div class="form-group row pt-3">
                            
                            <div class="col form-group">
                                <select class="form-control" name="level" id="level">
                                    @foreach ($levels as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <label for="level" class="form-control-placeholder">
                                        Education Level
                                </label>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male Staff</label>
                            </div>
                            <div class="col form-group">
                                <input type="text" id="female_number" name="female_number" class="form-control" required>
                                <label class="form-control-placeholder" for="female_number">Number of Female Staff</label>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>

                    </form>
                </div>

            </div>
        </div>
    @endif



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
