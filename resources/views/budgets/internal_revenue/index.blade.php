@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Internal Revenues</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <form action="internal-revenue/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm">
                                    Approve All Pending<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                               href="internal-revenue/create">New Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif
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
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="min-width: 95px;">Approval Status
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($internal_revenues as $internalRevenue)
                                <tr>
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($internalRevenue->approval_status == "Pending")
                                                <form action="internal-revenue/{{$internalRevenue->id}}/approve"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80"
                                                            data-toggle="tooltip" title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if($internalRevenue->approval_status != "Approved")
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="internal-revenue/{{$internalRevenue->id}}/edit"
                                                              method="GET">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-circle text-white btn-sm mx-0"
                                                                    style="opacity:0.80"
                                                                    data-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-pencil-alt fa-sm"
                                                                   style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col px-0">
                                                        <button type="submit"
                                                                class="btn btn-danger btn-circle text-white btn-sm mx-0 deleter"
                                                                style="opacity:0.80" data-id="{{$internalRevenue->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $internalRevenue->revenue_description }}</td>
                                    <td>{{ $internalRevenue->income }}</td>
                                    <td>{{ $internalRevenue->expense }}</td>
                                    <td>{{ $internalRevenue->income - $internalRevenue->expense }}</td>
                                    @if($internalRevenue->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check-double"></i> {{$internalRevenue->approval_status}}
                                        </td>
                                    @elseif($internalRevenue->approval_status == "College Approved")
                                        <td class="text-primary"><i
                                                    class="fas fa-check"></i> {{$internalRevenue->approval_status}}
                                        </td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$internalRevenue->approval_status}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
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

                        @if(count($errors) > 0)
                            <div class="col-md-12 form-group">
                                <div class="alert alert-danger">
                                    <h6 class="font-weight-bold">Please fix the following issues</h6>
                                    <hr class="my-0">
                                    <ul class="my-1 px-4">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('revenue_description', $revenue_descriptions , old('revenue_description') , ['class' => 'form-control', 'id' => 'add_revenue_description']) !!}
                            {!! Form::label('add_revenue_description', 'Revenue Description', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-md-6 form-group">
                            {{ Form::number('income', old('income'), ['class' => 'form-control', 'id' => 'add_income', 'required' => 'true']) }}
                            {{ Form::label('add_income', 'Income', ['class' => 'form-control-placeholder']) }}
                        </div>

                        <div class="col-md-6 form-group">
                            {!! Form::number('expense', old('expense'), ['class' => 'form-control', 'id' => 'add_expense', 'required' => 'true']) !!}
                            {!! Form::label('add_expense', 'Expense', ['class' => 'form-control-placeholder']) !!}
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

@endSection