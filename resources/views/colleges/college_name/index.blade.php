@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Colleges</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/college/college-name/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
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
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >College Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Acronym
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >Band
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($colleges as $college)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/college/college-name/{{$college->id}}/edit"
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
                                                      action="/college/college-name/{{$college->id}}"
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
                                    <td>{{ $college->college_name }}</td>
                                    <td>{{ $college->acronym }}</td>
                                    <td>{{ $college->bandName }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.colleges-name.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\CollegeNamesController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/college/college-name" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::select('band_name_id', $band_names, old('band_name_id')  , ['class' => 'form-control', 'id' => 'band_name_id']) !!}
                            {!! Form::label('band_name_id', 'Band', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('college_name', old('college_name'), ['class' => 'form-control', 'id' => 'add_college_name', 'required' => 'true']) !!}
                            {!! Form::label('add_college_name', 'College Name', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('college_acronym', old('college_acronym'), ['class' => 'form-control', 'id' => 'add_college_acronym', 'required' => 'true']) !!}
                            {!! Form::label('add_college_acronym', 'Acronym', ['class' => 'form-control-placeholder']) !!}
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif


    @if ($page_name == 'administer.colleges-name.edit')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form class="" action="/college/college-name/{{$id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i></button>
                        {{-- <a href="/department/department-name" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a> --}}
                    </div>


                    <div class="modal-body row p-4">
                        <div class="col-md-12 form-group pb-1">
                            <label class="label" for="band">Band</label>
                            <input type="text" id="band" name="band" class="form-control"
                                disabled value="{{$band."(".$band_acronym.")"}}">
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            <label class="label" for="college_name">College Name</label>
                            <input type="text" id="college_name" name="college_name" class="form-control"
                                 value="{{$college_name}}">
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            <label class="label" for="college_acronym">Acronym</label>
                            <input type="text" id="college_acronym" name="college_acronym" class="form-control"
                                value="{{$college_acronym}}">
                        </div>
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
