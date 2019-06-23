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
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable"
                                       width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 15%;">Managment Level
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
                                    @if (count($data['management_data']) > 0)
                                        @foreach ($data['management_data'] as $data)
                                            <tr role="row" class="odd"
                                                onclick="window.location='academic/{{$data->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="management-data/{{$data->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0"
                                                                  action="/institution/non-admin/{{$data->id}}"
                                                                  method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit"
                                                                        class="form-control form-control-plaintext text-danger p-0">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td class="sorting_1">{{$data->management_level}}</td>
                                                <td>{{$data->required_position_number}}</td>
                                                <td>{{$data->currently_assigned_number}}</td>
                                                <td>{{$data->female_number}}</td>
                                            </tr>
                                        @endforeach
                                    @else

                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if ($data['page_name'] == 'institutions.management_data.create')
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <form class="" action="/institution/management-data" method="POST">
                                @csrf
                                <h3 class="font-weight-bold text-primary">Add Management Data</h3>
                                <div class="row">
                                </div>
                                <div class="modal-body row p-2">
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
                                                        @foreach ($data['management_levels'] as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="empType" class="form-control-placeholder pt-3">Managment
                                                        Level</label>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="form-row ptt-1">
                                                    <div class="col form-group">
                                                        <input type="text" id="positions_required"
                                                               name="required_positions" class="form-control" required>
                                                        <label class="form-control-placeholder"
                                                               for="positions_required">Positions Required</label>
                                                    </div>

                                                    <div class="col form-group">
                                                        <input type="text" id="positions_assigned"
                                                               name="assigned_positions" class="form-control" required>
                                                        <label class="form-control-placeholder"
                                                               for="positions_assigned">Positions Assigned</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="no_of_females" name="number_of_females"
                                                       class="form-control" required>
                                                <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
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

        @if ($data['page_name'] == 'institutions.management_data.edit')
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <form class="" action="/institution/management-data/" method="POST">
                                @csrf
                                <h3 class="font-weight-bold text-primary">Edit Management Data</h3>
                                <div class="row">
                                </div>
                                <div class="modal-body row p-2">
                                    <div class="col-12">
                                        @if(count($errors) > 0)
                                            @foreach($errors->all() as $error)
                                                <div class="alert alert-danger">
                                                    {{$error}}
                                                </div>
                                            @endforeach
                                        @endif
                                        <fieldset class="card shadow h-100">
                                            <div class="card-header text-primary">
                                                Aggregate Information
                                            </div>

                                            <div class="form-row pt-3">
                                                <div class="col-md form-group">

                                                    <select class="form-control" id="manLevel" name="management_level">
                                                        @foreach ($data['management_levels'] as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="empType" class="form-control-placeholder pt-3">Managment
                                                        Level</label>
                                                </div>
                                            </div>

                                            <div class="card-body px-4">
                                                <div class="form-row ptt-1">
                                                    <div class="col form-group">
                                                        <input type="text" id="positions_required"
                                                               name="required_positions" class="form-control" required>
                                                        <label class="form-control-placeholder"
                                                               for="positions_required">Positions Required</label>
                                                    </div>

                                                    <div class="col form-group">
                                                        <input type="text" id="positions_assigned"
                                                               name="assigned_positions" class="form-control" required>
                                                        <label class="form-control-placeholder"
                                                               for="positions_assigned">Positions Assigned</label>
                                                    </div>
                                                </div>
                                                <div class="col form-group">
                                                    <input type="text" id="no_of_females" name="number_of_females"
                                                           class="form-control" required>
                                                    <label class="form-control-placeholder" for="no_of_females">Females(Aggregate)</label>
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
