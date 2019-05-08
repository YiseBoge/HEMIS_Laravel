@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Budgets</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-3 m-3 text-center">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="" data-toggle="modal"
                           data-target="#createModal">Add<i
                                    class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    {!! Form::open(['action' => 'Institution\BudgetsController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    <div class="col-md-6 px-3 py-md-1">
                        <div class="form-group">
                            {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , $data['budget_type'] , ['class' => 'form-control', 'id' => 'add_budget_type', 'onchange' => 'this.form.submit()']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'add_budget_type']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
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
                                        @foreach($data['budgets'] as $budget)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="" class="mr-2 d-inline text-primary" data-toggle="modal"
                                                       data-target="#editModal"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $budget->budgetDescription->budget_code }}</td>
                                                <td>{{ $budget->budgetDescription->description }}</td>
                                                <td>{{ $budget->allocated_budget }}</td>
                                                <td>{{ $budget->additional_budget }}</td>
                                                <td>234532</td>
                                                <td>45000</td>
                                                <td>{{ $budget->utilized_budget }}</td>
                                                <td>23699</td>
                                                <td>22%</td>
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


    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                {!! Form::open(['action' => 'Institution\BudgetsController@store', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body row pt-4">
                    <div class="col-12 form-group pb-2">
                        {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , null , ['class' => 'form-control', 'id' => 'add_budget_type']) !!}
                        {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'add_budget_type']) !!}
                    </div>

                    <div class="col-12 form-group pb-2">
                        {{--TODO get from budget descriptions--}}
                        {!! Form::select('budget_description', \App\Models\Institution\BudgetDescription::all() , null , ['class' => 'form-control', 'id' => 'add_budget_description']) !!}
                        {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'add_budget_description']) !!}
                    </div>

                    <div class="col-md-4 form-group">
                        {!! Form::number('allocated', null, ['class' => 'form-control', 'id' => 'add_allocated']) !!}
                        {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'add_allocated']) !!}
                    </div>

                    <div class="col-md-4 form-group">
                        {!! Form::number('additional', null, ['class' => 'form-control', 'id' => 'add_additional']) !!}
                        {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'add_additional']) !!}
                    </div>

                    <div class="col-md-4 form-group">
                        {!! Form::number('utilized', null, ['class' => 'form-control', 'id' => 'add_utilized']) !!}
                        {!! Form::label('utilized', 'Utilized', ['class' => 'form-control-placeholder', 'for' => 'add_utilized']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
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