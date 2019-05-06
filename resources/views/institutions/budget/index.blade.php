@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Budgets</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 p-3">
                        <div class="form-group row">
                            <select id="add_budget_type" class="form-control">
                                <option>Capital Budget</option>
                                <option>Recurrent Budget</option>
                            </select>
                            <label class="form-control-placeholder" for="add_budget_type">Budget Type</label>

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_length" id="dataTable_length"><label>Show <select
                                                name="dataTable_length" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input
                                                type="search" class="form-control form-control-sm" placeholder=""
                                                aria-controls="dataTable"></label></div>
                            </div>
                            <div class="col-sm-12 col-md-2 text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="" data-toggle="modal"
                                   data-target="#createModal">Add<i
                                            class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
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
                                            aria-label="Name: activate to sort column descending"
                                        >Budget Code
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Budget Description
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Allocated Budget
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Additional Budget
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Internal Transfer
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Adjusted Budget
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Utilized Budget
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Difference
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Performance in %
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
                                        <td>BU003</td>
                                        <td>This is a budget with this this this this</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                        <td>45000</td>
                                        <td>434555</td>
                                        <td>23699</td>
                                        <td>22%</td>
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
                                        <td>BU003</td>
                                        <td>This is a budget with this this this this</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                        <td>45000</td>
                                        <td>434555</td>
                                        <td>23699</td>
                                        <td>40%</td>
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
                                        <td>BU003</td>
                                        <td>This is a budget with this this this this</td>
                                        <td>1000000</td>
                                        <td>32345</td>
                                        <td>234532</td>
                                        <td>45000</td>
                                        <td>45000</td>
                                        <td>434555</td>
                                        <td>55%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="dataTable_info" role="status"
                                     aria-live="polite">Showing 1 to 10 of 57 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled"
                                            id="dataTable_previous"><a href="#" aria-controls="dataTable"
                                                                       data-dt-idx="0" tabindex="0"
                                                                       class="page-link">Previous</a></li>
                                        <li class="paginate_button page-item active"><a href="#"
                                                                                        aria-controls="dataTable"
                                                                                        data-dt-idx="1"
                                                                                        tabindex="0"
                                                                                        class="page-link">1</a>
                                        </li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                  aria-controls="dataTable"
                                                                                  data-dt-idx="2" tabindex="0"
                                                                                  class="page-link">2</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                  aria-controls="dataTable"
                                                                                  data-dt-idx="3" tabindex="0"
                                                                                  class="page-link">3</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                  aria-controls="dataTable"
                                                                                  data-dt-idx="4" tabindex="0"
                                                                                  class="page-link">4</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                  aria-controls="dataTable"
                                                                                  data-dt-idx="5" tabindex="0"
                                                                                  class="page-link">5</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                  aria-controls="dataTable"
                                                                                  data-dt-idx="6" tabindex="0"
                                                                                  class="page-link">6</a></li>
                                        <li class="paginate_button page-item next" id="dataTable_next"><a
                                                    href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0"
                                                    class="page-link">Next</a></li>
                                    </ul>
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
                <form method="post" action="/institution/budget/store">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            <select id="add_budget_type" class="form-control">
                                <option>Capital Budget</option>
                                <option>Recurrent Budget</option>
                            </select>
                            <label class="form-control-placeholder" for="add_budget_type">Budget Type</label>
                        </div>

                        <div class="col-12 form-group pb-2">
                            <select id="add_budget_description" class="form-control">
                                <option>BU003 - This is a budget with this this this this</option>
                                <option>BU004 - This is a budget with that that that that</option>
                            </select>
                            <label class="form-control-placeholder" for="add_budget_description">Budget
                                Description</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="add_allocated" class="form-control" required>
                            <label class="form-control-placeholder" for="add_allocated">Allocated</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="add_additional" class="form-control" required>
                            <label class="form-control-placeholder" for="add_additional">Additional</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="add_utilized" class="form-control" required>
                            <label class="form-control-placeholder" for="add_utilized">Utilized</label>
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
                <form method="post" action="/institution/budget/update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            <select id="edit_budget_type" class="form-control">
                                <option>Capital Budget</option>
                                <option>Recurrent Budget</option>
                            </select>
                            <label class="form-control-placeholder" for="edit_budget_type">Budget Type</label>
                        </div>

                        <div class="col-12 form-group pb-2">
                            <select id="edit_budget_description" class="form-control">
                                <option>BU003 - This is a budget with this this this this</option>
                                <option>BU004 - This is a budget with that that that that</option>
                            </select>
                            <label class="form-control-placeholder" for="edit_budget_description">Budget
                                Description</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_allocated" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_allocated">Allocated</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_additional" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_additional">Additional</label>
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="number" id="edit_utilized" class="form-control" required value="3243">
                            <label class="form-control-placeholder" for="edit_utilized">Utilized</label>
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
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection