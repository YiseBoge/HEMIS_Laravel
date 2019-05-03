@extends('layouts.app')

@section('content')
    <div class="container w-75">
        <h1 class="font-weight-bold text-primary">ICT Staff Types</h1>
        <div class="card shadow-sm pt-3 mt-3">
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

                <table class="table border dataTable" width="100%"
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
                            <td><a href="#" class="btn btn-sm text-primary" data-toggle="modal" data-target="#editModal">Edit</a></td>
                            <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                        </tr>
                        <tr>
                            <td>Network Administrator</td>
                            <td><a href="#" class="btn btn-sm text-primary" data-toggle="modal" data-target="#editModal">Edit</a></td>
                            <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                        </tr>                        
                    </tbody>
                </table>
                <div class="form-group row mt-4">
                    <div class="col-md-8">
                        <input type="text" id="ict_staff_type" name="ict_staff_type" class="form-control"
                        placeholder="Add New Type">
                    </div>
                    <div class="col-md-1">
                        <input type="submit" class="btn btn-outline-primary" value="Add">
                    </div>
                </div> 

            </div>
        </div>
        
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTitle">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
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