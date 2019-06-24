@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Teachers on Special Program</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                           href="/department/special-program-teacher/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    {!! Form::open(['action' => 'Department\SpecialProgramTeacherController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    <div class="form-row">
                        <div class="col-md-6 px-3 py-md-1 col">
                            <div class="form-group">
                                {!! Form::select('program_status', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramStats') , $selected_status , ['class' => 'form-control', 'id' => 'add_program_status', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('program_status', 'Program Status', ['class' => 'form-control-placeholder', 'for' => 'add_program_status']) !!}
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
                                >Program
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                >Male
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                >Female
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($special_program_teachers as $specialProgramTeacher)
                                <tr>
                                    <td class="text-center">
                                        <a href=""
                                           class="mr-2 d-inline text-primary"><i
                                                    class="far fa-edit"></i> </a>
                                        <a href="" class="d-inline text-danger" data-toggle="modal"
                                           data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>

                                    <td>{{ $specialProgramTeacher->program_type}}</td>
                                    <td>{{ $specialProgramTeacher->male_number }}</td>
                                    <td>{{ $specialProgramTeacher->female_number }}</td>
                                </tr>
                            @endforeach
                            </tbody>


                        </table>
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