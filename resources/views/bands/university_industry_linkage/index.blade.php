@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">University Industry Linkage</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                           href="/student/university-industry-linkage/create">New Entry<i
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
                                >Number of Industries Linked
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Training Area
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Number of Students
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($linkages as $linkage)
                                <tr>
                                    <td class="text-center">
                                        <a href=""
                                           class="mr-2 d-inline text-primary"><i
                                                    class="far fa-edit"></i> </a>
                                        <a href="" class="d-inline text-danger" data-toggle="modal"
                                           data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td>{{ $linkage->year}}</td>
                                    <td>{{ $linkage->number_of_industry_links }}</td>
                                    <td>{{ $linkage->training_area }}</td>
                                    <td>{{ $linkage->number_of_students }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'bands.university_industry_linkage.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="pb-5" action="/student/university-industry-linkage" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTitle">Add</h5>
                            <a href="/student/university-industry-linkage" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>

                        <div class="modal-body pt-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="year" id="year">
                                        @foreach ($years as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="year" class="form-control-placeholder">
                                        Year Level
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="industry_number" name="industry_number"
                                           class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="industry_number">Linked
                                        Industries</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="training_area" name="training_area" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="training_area">Training Area</label>
                                </div>
                                <div class="col form-group">
                                    <input type="number" id="number_of_students" name="number_of_students"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="number_of_students">Number of
                                        Students</label>
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


    @if ($page_name == 'institution.budget.edit')

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
                    <a class="btn btn-danger" href="/student/university-industry-linkage/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection
