@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Private Investments</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <form action="private-investment/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm" {{count($investments) == 0 ? 'disabled' : ''}}>
                                    Approve All Pending<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                               href="private-investment/create">New Entry<i
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
                                    aria-label="Name: activate to sort column descending">Investment Title
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending">Cost
                                    Incured
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending">Remarks
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="min-width: 95px;">Approval Status
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($investments as $investment)
                                <tr>
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($investment->approval_status == "Pending")
                                                <form action="private-investment/{{$investment->id}}/approve"
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
                                            @if(!in_array($investment->approval_status, ["Approved", "College Approved"]))
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="/budgets/private-investment/{{$investment->id}}/edit"
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
                                                                style="opacity:0.80"
                                                                data-id="{{$investment->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $investment->investment_title }}</td>
                                    <td>{{ $investment->cost_incurred }}</td>
                                    <td>{{ $investment->remarks }}</td>
                                    @if($investment->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check-double"></i> {{$investment->approval_status}}
                                        </td>
                                    @elseif($investment->approval_status == "College Approved")
                                        <td class="text-primary"><i
                                                    class="fas fa-check"></i> {{$investment->approval_status}}
                                        </td>
                                    @elseif($investment->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$investment->approval_status}}
                                        </td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$investment->approval_status}}
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

    @if ($page_name == 'budgets.investment.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\InvestmentsController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTitle">Add</h5>
                        <a href="/budgets/private-investment" class="close" aria-label="Close">
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
                            {!! Form::select('investment_title', $investment_titles , old('investment_title') , ['class' => 'form-control', 'id' => 'add_investment_title']) !!}
                            {!! Form::label('add_investment_title', 'Investment Title', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::number('cost_incurred', old('cost_incurred'), ['class' => 'form-control', 'id' => 'add_cost_incurred', 'required' => 'true']) !!}
                            {!! Form::label('add_cost_incurred', 'Cost Incured', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::textarea('remarks', old('remarks'), ['class' => 'form-control', 'id' => 'add_remarks']) !!}
                            {!! Form::label('add_remarks', 'Remarks', ['class' => 'form-control-placeholder']) !!}
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

    @if ($page_name == 'budgets.private_investment.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['College\InvestmentsController@update', $investment->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/private-investment" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('investment_title', $investment_titles , $investment_title , ['class' => 'form-control', 'id' => 'edit_investment_title']) !!}
                            {!! Form::label('investment_title', 'Investment Title', ['class' => 'form-control-placeholder', 'for' => 'edit_investment_title']) !!}

                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::number('cost_incurred', $investment->cost_incurred, ['class' => 'form-control', 'id' => 'edit_cost_incurred', 'required' => 'true']) !!}
                            {!! Form::label('cost_incurred', 'Cost Incured', ['class' => 'form-control-placeholder', 'for' => 'edit_cost_incurred']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::textarea('remarks', $investment->remarks, ['class' => 'form-control', 'id' => 'edit_remarks']) !!}
                            {!! Form::label('remarks', 'Remarks', ['class' => 'form-control-placeholder', 'for' => 'edit_remarks']) !!}
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
@endSection