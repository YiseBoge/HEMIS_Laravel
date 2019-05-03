@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Budgets</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Budget Type</label>
                            <div class="col-md-8">
                                <select class="form-control">
                                    <option>Capital Budget</option>
                                    <option>Recurrent Budget</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table border dataTable" role="grid" aria-describedby="dataTable_info">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-primary">Budget Code</th>
                        <th class="text-primary">Budget Description</th>
                        <th class="text-primary">Allocated Budget</th>
                        <th class="text-primary">Additional Budget</th>
                        <th class="text-primary">Utilized Budget</th>
                        <th class="text-primary">Calculated1 Budget</th>
                        <th class="text-primary">Calculated2 Budget</th>
                        <th class="text-primary">Calculated3 Budget</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>BU003</td>
                        <td>This is a budget with this this this this</td>
                        <td>1000000</td>
                        <td>32345</td>
                        <td>234532</td>
                        <td>45000</td>
                        <td>434555</td>
                        <td>23699</td>
                        <td>
                            <a href="1/edit" class="text-muted mr-3 d-inline"><i class="far fa-edit"></i> </a>
                            <a href="#" class="text-muted d-inline"><i class="far fa-trash-alt"></i> </a>
                        </td>
                    </tr>
                    <tr>
                        <td>BU003</td>
                        <td>This is a budget with this this this this</td>
                        <td>1000000</td>
                        <td>32345</td>
                        <td>234532</td>
                        <td>45000</td>
                        <td>434555</td>
                        <td>23699</td>
                        <td>
                            <a href="1/edit" class="text-muted mr-3 d-inline"><i class="far fa-edit"></i> </a>
                            <a href="#" class="text-muted d-inline"><i class="far fa-trash-alt"></i> </a>
                        </td>
                    </tr>
                    <tr>
                        <td>BU003</td>
                        <td>This is a budget with this this this this</td>
                        <td>1000000</td>
                        <td>32345</td>
                        <td>234532</td>
                        <td>45000</td>
                        <td>434555</td>
                        <td>23699</td>
                        <td>
                            <a href="1/edit" class="text-muted mr-3 d-inline"> Edit </a>
                            <a href="#" class="text-muted d-inline"> Delete </a>
                        </td>
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