@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Management Data</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/institution/management-data/create">New
                            Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
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
                            >Managment Level
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                            >Position Required
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Currently Assigned
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Females(Number)
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($management_data as $data)
                            <tr role="row" class="odd">
                                <td class="text-center">
                                    <div class="row px-1">
                                        <div class="col px-0">
                                            <form class="p-0"
                                                  action="management-data/{{$data->id}}/edit"
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
                                                  action="management-data/{{$data->id}}"
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
                                </td>
                                <td class="sorting_1">{{$data->management_level}}</td>
                                <td>{{$data->required}}</td>
                                <td>{{$data->assigned}}</td>
                                <td>{{$data->female_number}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @if ($page_name == 'institutions.management_data.create')
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                        <form class="" action="/institution/management-data" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTitle">Add</h5>
                                <a href="/institution/management-data" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            </div>

                            <div class="modal-body row pt-4">
                                <div class="col-12">
                                    @if(count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{$error}}
                                            </div>
                                        @endforeach
                                    @endif
                                    <fieldset class="h-100">
                                        <div class="form-row pt-3">
                                            <div class="col-md form-group">

                                                <select class="form-control" id="manLevel" name="management_level">
                                                    @foreach ($management_levels as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="management_level" class="form-control-placeholder pt-3">Management
                                                    Level</label>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="form-row ptt-1">
                                                <div class="col form-group">
                                                    <input type="number" id="positions_required"
                                                           name="required_positions" class="form-control" required>
                                                    <label class="form-control-placeholder"
                                                           for="positions_required">Positions Required</label>
                                                </div>

                                                <div class="col form-group">
                                                    <input type="number" id="positions_assigned"
                                                           name="assigned_positions" class="form-control" required>
                                                    <label class="form-control-placeholder"
                                                           for="positions_assigned">Positions Assigned</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="no_of_females" name="number_of_females"
                                                   class="form-control" required>
                                            <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
                            </div>
                    </div>

                </div>
            </div>
        @endif

        @if ($page_name == 'institutions.management_data.edit')
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                        <form class="" action="/institution/management-data/{{$current->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTitle">Edit</h5>
                                <a href="/institution/management-data" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            </div>

                            <div class="modal-body row pt-4">
                                <div class="col-12">
                                    @if(count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{$error}}
                                            </div>
                                        @endforeach
                                    @endif
                                    <fieldset class="h-100">
                                        <div class="form-row pt-3">
                                            <div class="col-md form-group">
                                                <select class="form-control" id="manLevel" name="management_level">
                                                    @foreach ($management_levels as $key => $value)
                                                        @if($value == $current->management_level)
                                                            <option value="{{$key}}" selected>{{$value}}</option>
                                                        @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label for="management_level" class="form-control-placeholder pt-3">Management
                                                    Level</label>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="form-row ptt-1">
                                                <div class="col form-group">
                                                    <input type="number" id="positions_required"
                                                           name="required_positions" value="{{$current->required}}"
                                                           class="form-control" required>
                                                    <label class="form-control-placeholder"
                                                           for="positions_required">Positions Required</label>
                                                </div>

                                                <div class="col form-group">
                                                    <input type="number" id="positions_assigned"
                                                           name="assigned_positions" value="{{$current->assigned}}"
                                                           class="form-control" required>
                                                    <label class="form-control-placeholder"
                                                           for="positions_assigned">Positions Assigned</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="no_of_females" name="number_of_females"
                                                   value="{{$current->female_number}}"
                                                   class="form-control" required>
                                            <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
                                        </div>
                                    </fieldset>
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