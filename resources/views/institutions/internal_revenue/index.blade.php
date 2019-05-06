@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Internal Revenues</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-3 m-3 text-center">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="" data-toggle="modal"
                           data-target="#createModal">Add<i
                                    class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                                       width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">

                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1"
                                            style="min-width: 50px; width: 50px"
                                        >
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">Description
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending">Income
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending">Expense
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending">Balance
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Farming</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Education Programs Tuition Fee</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Training and Consultancy</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Business Entities*</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Funds</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Hospital Services</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Others/Payable</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                               data-target="#editModal"><i
                                                        class="far fa-edit"></i> </a>
                                            <a href="" class="d-inline text-danger" data-toggle="modal"
                                               data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                        <td>Total</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                    </tr>

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


    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <form method="post" action="/institution/internal-revenue/store">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            <select id="add_revenue_description" class="form-control">
                                <option>Farming</option>
                                <option>Education Programs Tuition Fee</option>
                                <option>Training and Consultancy</option>
                                <option>Business Entities*</option>
                                <option>Funds</option>
                                <option>Hospital Services</option>
                                <option>Others/Payable</option>
                                <option>Total</option>
                            </select>
                            <label class="form-control-placeholder" for="add_revenue_description">Revenue
                                Description</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_income" class="form-control" required>
                            <label class="form-control-placeholder" for="edit_income">Income</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_expense" class="form-control" required>
                            <label class="form-control-placeholder" for="edit_expense">Expense</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_balance" class="form-control" required>
                            <label class="form-control-placeholder" for="edit_balance">Balance</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <form method="post" action="/institution/internal-revenue/update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            <select id="edit_revenue_description" class="form-control">
                                <option>Farming</option>
                                <option>Education Programs Tuition Fee</option>
                                <option>Training and Consultancy</option>
                                <option>Business Entities*</option>
                                <option>Funds</option>
                                <option>Hospital Services</option>
                                <option>Others/Payable</option>
                            </select>
                            <label class="form-control-placeholder" for="edit_revenue_description">Revenue
                                Description</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_income" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_income">Income</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_expense" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_expense">Expense</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_balance" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_balance">Balance</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
                    <a class="btn btn-danger" href="/institution/internal-revenue/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection