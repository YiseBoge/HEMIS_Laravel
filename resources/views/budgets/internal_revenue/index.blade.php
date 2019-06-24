@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Internal Revenues</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/budgets/internal-revenue/create">New
                            Entry<i
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
                            @foreach($internal_revenues as $internalRevenue)
                                <tr>
                                    <td class="text-center">
                                        <a href="/budgets/internal-revenue/{{ $internalRevenue->id }}/edit"
                                           class="mr-2 d-inline text-primary"><i
                                                    class="far fa-edit"></i> </a>
                                        <a href="" class="d-inline text-danger" data-toggle="modal"
                                           data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td>{{ $internalRevenue->revenue_description }}</td>
                                    <td>{{ $internalRevenue->income }}</td>
                                    <td>{{ $internalRevenue->expense }}</td>
                                    <td>{{ $internalRevenue->income - $internalRevenue->expense }}</td>
                                </tr>
                            @endforeach
                            </tbody>

                            {{--                                        <tfoot>--}}
                            {{--                                        <tr class="font-weight-bolder font-italic text-lg">--}}
                            {{--                                            <td class="text-center">--}}

                            {{--                                            </td>--}}
                            {{--                                            <td>Total</td>--}}
                            {{--                                            <td>sum of incomes</td>--}}
                            {{--                                            <td>sum of expenses</td>--}}
                            {{--                                            <td>sum of balances</td>--}}
                            {{--                                        </tr>--}}
                            {{--                                        </tfoot>--}}
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>


    @if ($page_name == 'budgets.internal-revenue.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\InternalRevenuesController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/budgets/internal-revenue" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('revenue_description', $revenue_descriptions , null , ['class' => 'form-control', 'id' => 'add_revenue_description']) !!}
                            {!! Form::label('revenue_description', 'Revenue Description', ['class' => 'form-control-placeholder', 'for' => 'add_revenue_description']) !!}
                        </div>

                        <div class="col-md-6 form-group">
                            {!! Form::number('income', null, ['class' => 'form-control', 'id' => 'add_income', 'required' => 'true']) !!}
                            {!! Form::label('income', 'Income', ['class' => 'form-control-placeholder', 'for' => 'add_income']) !!}
                        </div>

                        <div class="col-md-6 form-group">
                            {!! Form::number('expense', null, ['class' => 'form-control', 'id' => 'add_expense', 'required' => 'true']) !!}
                            {!! Form::label('expense', 'Expense', ['class' => 'form-control-placeholder', 'for' => 'add_expense']) !!}
                        </div>

                        {{--                        <div class="col-md-4 form-group">--}}
                        {{--                            {!! Form::number('balance', null, ['class' => 'form-control', 'id' => 'edit_balance', 'required' => 'true']) !!}--}}
                        {{--                            {!! Form::label('balance', 'Balance', ['class' => 'form-control-placeholder', 'for' => 'edit_balance']) !!}--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif

    @if ($page_name == 'budgets.internal-revenue.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['College\InternalRevenuesController@update', $internal_revenue->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/internal-revenue" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('revenue_description', $revenue_descriptions , $revenue_description , ['class' => 'form-control', 'id' => 'edit_revenue_description']) !!}
                            {!! Form::label('revenue_description', 'Revenue Description', ['class' => 'form-control-placeholder', 'for' => 'edit_revenue_description']) !!}
                        </div>

                        <div class="col-md-6 form-group">
                            {!! Form::number('income', $internal_revenue->income, ['class' => 'form-control', 'id' => 'edit_income', 'required' => 'true']) !!}
                            {!! Form::label('income', 'Income', ['class' => 'form-control-placeholder', 'for' => 'edit_income']) !!}
                        </div>

                        <div class="col-md-6 form-group">
                            {!! Form::number('expense', $internal_revenue->expense, ['class' => 'form-control', 'id' => 'edit_expense', 'required' => 'true']) !!}
                            {!! Form::label('expense', 'Expense', ['class' => 'form-control-placeholder', 'for' => 'edit_expense']) !!}
                        </div>

                        {{--                        <div class="col-md-4 form-group">--}}
                        {{--                            {!! Form::number('balance', $data['internal-revenue']->balance, ['class' => 'form-control', 'id' => 'edit_balance', 'required' => 'true']) !!}--}}
                        {{--                            {!! Form::label('balance', 'Balance', ['class' => 'form-control-placeholder', 'for' => 'edit_balance']) !!}--}}
                        {{--                        </div>--}}
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
                    <a class="btn btn-danger" href="/budgets/internal-revenue/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection