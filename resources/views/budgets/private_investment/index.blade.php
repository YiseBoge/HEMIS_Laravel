@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Private Investments</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-3 m-3 text-center">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="/budgets/private-investment/create">
                            Add<i class="fas fa-plus ml-2"></i></a>
                    </div>
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
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($data['investments'] as $investment)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="/budgets/private-investment/{{ $investment->id }}/edit"
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $investment->investment_title }}</td>
                                                <td>{{ $investment->cost_incurred }}</td>
                                                <td>{{ $investment->remarks }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>


                                        {{--                                        <tfoot>--}}
                                        {{--                                        <tr class="font-weight-bolder font-italic text-lg">--}}
                                        {{--                                            <td class="text-center">--}}

                                        {{--                                            </td>--}}
                                        {{--                                            <td>Total</td>--}}
                                        {{--                                            <td>sum of cost incured</td>--}}
                                        {{--                                            <td></td>--}}
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

    @if ($data['page_name'] == 'budgets.investment.create')
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
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('investment_title', $data['investment_titles'] , null , ['class' => 'form-control', 'id' => 'add_investment_title']) !!}
                            {!! Form::label('investment_title', 'Investment Title', ['class' => 'form-control-placeholder', 'for' => 'add_investment_title']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::number('cost_incurred', null, ['class' => 'form-control', 'id' => 'add_cost_incurred', 'required' => 'true']) !!}
                            {!! Form::label('cost_incurred', 'Cost Incured', ['class' => 'form-control-placeholder', 'for' => 'add_cost_incurred']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::textarea('remarks', '', ['class' => 'form-control', 'id' => 'add_remarks']) !!}
                            {!! Form::label('remarks', 'Remarks', ['class' => 'form-control-placeholder', 'for' => 'add_remarks']) !!}
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

    @if ($data['page_name'] == 'budgets.investment.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['College\InvestmentsController@update', $data['investment']->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/private-investment" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('investment_title', $data['investment_titles'] , $data['investment_title'] , ['class' => 'form-control', 'id' => 'edit_investment_title']) !!}
                            {!! Form::label('investment_title', 'Investment Title', ['class' => 'form-control-placeholder', 'for' => 'edit_investment_title']) !!}

                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::number('cost_incurred', $data['investment']->cost_incurred, ['class' => 'form-control', 'id' => 'edit_cost_incurred', 'required' => 'true']) !!}
                            {!! Form::label('cost_incurred', 'Cost Incured', ['class' => 'form-control-placeholder', 'for' => 'edit_cost_incurred']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::textarea('remarks', $data['investment']->remarks, ['class' => 'form-control', 'id' => 'edit_remarks']) !!}
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
                    <a class="btn btn-danger" href="/institution/private-investment/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection