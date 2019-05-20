@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Semesters</div>
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6 text-right">
                        <a href="/editors/create" class="btn btn-outline-primary btn-sm mb-0">
                            New Entry<i class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>

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
                                            >Name
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Institution
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Email
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($editors as $editor)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $editor->name }}</td>
                                                <td>{{ $editor->institution() }}</td>
                                                <td>{{ $editor->email }}</td>
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
