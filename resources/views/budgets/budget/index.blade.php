@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Budgets</div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/budgets/budget/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    {!! Form::open(['action' => 'College\BudgetsController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                    <div class="col-md-6 px-3 py-md-1">
                        <div class="form-group">
                            {!! Form::select('budget_type', $budget_types , $budget_type , ['class' => 'form-control', 'id' => 'add_budget_type', 'onchange' => 'this.form.submit()']) !!}
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
                                        @foreach($budgets as $budget)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="/institution/budget/{{ $budget->id }}/edit"
                                                       class="mr-2 d-inline text-primary"><i
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

                                        {{--                                        <tfoot>--}}
                                        {{--                                        <tr class="font-weight-bolder font-italic text-lg">--}}
                                        {{--                                            <td class="text-center">--}}

                                        {{--                                            </td>--}}
                                        {{--                                            <td colspan="2">Total</td>--}}
                                        {{--                                            <td>allocated sum</td>--}}
                                        {{--                                            <td>additional sum</td>--}}
                                        {{--                                            <td>internal transfer sum</td>--}}
                                        {{--                                            <td>adjusted sum</td>--}}
                                        {{--                                            <td>utilized sum</td>--}}
                                        {{--                                            <td>difference sum</td>--}}
                                        {{--                                            <td>performance average?</td>--}}
                                        {{--                                        </tr>--}}
                                        {{--                                        </tfoot>--}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'budgets.budget.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\BudgetsController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/budgets/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', $budget_types, null , ['class' => 'form-control', 'id' => 'add_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'add_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_description', $budget_descriptions , null , ['class' => 'form-control', 'id' => 'add_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'add_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', 0, ['class' => 'form-control', 'id' => 'add_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'add_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', 0, ['class' => 'form-control', 'id' => 'add_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'add_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', 0, ['class' => 'form-control', 'id' => 'add_utilized', 'required' => 'true']) !!}
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
    @endif


    @if ($page_name == 'budgets.budget.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['College\BudgetsController@update', $budget->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', $budget_types , $budget_type, ['class' => 'form-control', 'id' => 'edit_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_description', $budget_descriptions , $budget_description, ['class' => 'form-control', 'id' => 'edit_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', $budget->allocated_budget, ['class' => 'form-control', 'id' => 'edit_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'edit_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', $budget->additional_budget, ['class' => 'form-control', 'id' => 'edit_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'edit_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', $budget->utilized_budget, ['class' => 'form-control', 'id' => 'edit_utilized', 'required' => 'true']) !!}
                            {!! Form::label('utilized', 'Utilized', ['class' => 'form-control-placeholder', 'for' => 'edit_utilized']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::hidden('_method', 'PUT') !!}
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
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
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection