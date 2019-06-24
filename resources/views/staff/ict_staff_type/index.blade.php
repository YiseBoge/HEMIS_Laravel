@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ICT Staff Types</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Category</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Infrastructure & Services</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table border dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th class="text-primary">ICT Staff Type</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Junior Network Administrator</td>
                            <td><a href="#" class="text-primary" data-toggle="modal" data-target="#editModal">
                                    <i class="far fa-edit mr-1"></i> Edit</a></td>
                            <td><a href="#" class="text-primary"><i class="far fa-trash-alt mr-1"></i> Delete</a></td>
                        </tr>
                        <tr>
                            <td>Network Administrator</td>
                            <td><a href="#" class="text-primary" data-toggle="modal" data-target="#editModal">
                                    <i class="far fa-edit mr-1"></i> Edit</a></td>
                            <td><a href="#" class="text-primary"><i class="far fa-trash-alt mr-1"></i> Delete</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-md-8">
                        <input type="text" id="ict_staff_type" name="ict_staff_type" class="form-control"
                               placeholder="Add New Type">
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-primary btn-sm mb-0 shadow-sm" value="Add">
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
                    <a href="/staff/ict-staff-types" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Category</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option>Infrastructure & Services</option>
                            </select>
                        </div>
                    </div>
                    <input class="form-control " id="phoneno" type="text" value="Junior Network Administrator">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endSection