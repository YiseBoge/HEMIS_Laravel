@extends('layouts.app')

@section('content')
    <div class="container w-75">
        <h1 class="font-weight-bold text-primary">Institutions</h1>
        <div class="card shadow-sm pt-3 mt-3">
            <div class="card-body">

                <table class="table border dataTable" width="100%"
                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                       style="width: 100%;">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-primary">Institution Name</th>
                        <th class="text-primary">Acronym</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Adigrat University</td>
                        <td>AU</td>
                        <td><a href="#" class="btn btn-sm text-primary" data-toggle="modal" data-target="#editModal">Edit</a>
                        </td>
                        <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                    </tr>
                    <tr>
                        <td>Addis Ababa University</td>
                        <td>AAU</td>
                        <td><a href="#" class="btn btn-sm text-primary" data-toggle="modal" data-target="#editModal">Edit</a>
                        </td>
                        <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group row mt-4">
                    <div class="col-md-8">
                        <input type="text" id="institution_name" name="institution_name" class="form-control"
                               placeholder="Add New Type">
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-outline-primary" value="Add">
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input class="form-control " id="institution_name_edit" type="text" value="Addis Ababa University">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endSection
