@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Semesters</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col-md-5 form-group pb-1">
                        {!! Form::open(['action' => 'Institution\InstancesController@updateCurrentInstance', 'method' => 'POST']) !!}
                        {!! Form::select('current_instance', $instances , $current, ['class' => 'form-control', 'id' => 'edit_current_instance']) !!}
                        {!! Form::label('edit_current_instance', 'Current Semester', ['class' => 'form-control-placeholder']) !!}
                        {!! Form::submit('Apply Change', ['class' => 'my-2 btn-sm btn btn-outline-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/institution/instance/create">New Entry<i
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
                                >Year
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Semester
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($instances as $instance)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/institution/instance/{{$instance->id}}/edit"
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
                                        </div>
                                    </td>
                                    <td>{{ $instance->year }}</td>
                                    <td>{{ $instance->semester }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.instance.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'Institution\InstancesController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/institution/instance" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row p-4">

                        @if(count($errors) > 0)
                            <div class="col-md-12 form-group">
                                <div class="alert alert-danger">
                                    <h6 class="font-weight-bold">Please fix the following issues</h6>
                                    <hr class="my-0">
                                    <ul class="my-1 px-4">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 form-group pb-1">
                            {!! Form::select('year', $years , old('year'), ['class' => 'form-control', 'id' => 'add_year', 'required' => 'true']) !!}
                            {!! Form::label('add_year', 'Year', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('semester', old('semester'), ['class' => 'form-control', 'id' => 'add_semester', 'required' => 'true']) !!}
                            {!! Form::label('add_semester', 'Semester', ['class' => 'form-control-placeholder']) !!}
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


    @if ($page_name == 'administer.instance.edit')
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                {!! Form::model($instance , ['action' => ['Institution\InstancesController@update' , $instance->id], 'method' => 'POST']) !!}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Add</h5>
                    <a href="/institution/instance" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>

                <div class="modal-body row p-4">
                    <div class="col-md-12 form-group pb-1">
                        {!! Form::text('year', $instance->year, ['class' => 'form-control', 'id' => 'add_year', 'required' => 'true']) !!}
                        {!! Form::label('add_year', 'Year', ['class' => 'form-control-placeholder']) !!}
                    </div>
                    <div class="col-md-12 form-group pb-1">
                        {!! Form::text('semester', $instance->semester, ['class' => 'form-control', 'id' => 'add_semester', 'required' => 'true']) !!}
                        {!! Form::label('add_semester', 'Semester', ['class' => 'form-control-placeholder']) !!}
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

@endSection
