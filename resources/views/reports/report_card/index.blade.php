@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Reports</div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col-sm text-right">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="">Print<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered"
                                           width="100%"
                                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                           style="width: 100%;">

                                        <thead>
                                        <tr role="row">
                                            <th style="min-width: 100px;">Policy
                                            </th>
                                            <th style="min-width: 100px;">Key
                                                Performance Indicators (KPI)
                                            </th>
                                            @foreach($years as $year)
                                                <th style="min-width: 100px;">{{ $year->year }}
                                                </th>
                                            @endforeach
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Year: activate to sort column ascending">Target
                                                (2025)
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Year: activate to sort column ascending">Change
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Year: activate to sort column ascending">
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($reports as $policy => $descriptions)
                                            <tr>
                                                <td class="bg-gray-200 font-weight-bold h5"
                                                    colspan="{{ count($years) + 5 }}">
                                                    {{ $policy }}
                                                </td>
                                            </tr>
                                            @foreach($descriptions as $description => $kpis)
                                                <tr>
                                                    <td rowspan="{{ count($kpis) + 1 }}">
                                                        {{ $description }}
                                                    </td>

                                                </tr>
                                                @foreach($kpis as $kpi)
                                                    <tr>
                                                        <td>
                                                            {{ $kpi->kpi }}
                                                        </td>
                                                        @foreach($kpi->reportYearValues as $yearValue)
                                                            <td>
                                                                {{ $yearValue->value }}
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            {{ $kpi->target }}
                                                        </td>
                                                        <td>
                                                            @if($kpi->change() > 0)
                                                                <p class="text-success">{{$kpi->change()}}% <i
                                                                            class="fa fa-caret-up d-inline-block ml-2"></i>
                                                                </p>
                                                            @elseif($kpi->change())
                                                                <p class="text-danger">{{$kpi->change()}}%<i
                                                                            class="fa fa-caret-down d-inline-block ml-2"></i>
                                                                </p>
                                                            @else
                                                                <p class="text-warning">{{$kpi->change()}}%</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="/report/{{ $kpi->id }}/edit"
                                                               class="mr-3 text-muted" data-toggle="tooltip"
                                                               title="Edit Target">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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

    @if ($page_name == 'reports.report_card.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Report\ReportsController@update', $report->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Set Target</h5>
                        <a href="/report" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body px-5">
                        <div class="row my-2">
                            <div class="col-md text-center">
                                @if($change > 0)
                                    <p class="h3 text-success">{{$change}}% <i
                                                class="fa fa-caret-up d-inline-block ml-2"></i></p>
                                @elseif($change < 0)
                                    <p class="h3 text-danger">{{$change}}%<i
                                                class="fa fa-caret-down d-inline-block ml-2"></i></p>
                                @else
                                    <p class="h3 text-warning">{{$change}}%(stagnant)</p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md alert alert-secondary font-weight-bolder">
                                {{ $report->policy }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md alert alert-secondary pl-4">
                                {{ $report->policy_description }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md alert alert-secondary pl-4">
                                {{ \App\Models\Report\ReportCard::getValueKey(\App\Models\Report\ReportCard::getEnum('kpi'), $report->kpi) }}
                                {{ $report->kpi }}
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-md">
                                Baseline :
                                @if ($baseline != null)
                                    {{ $baseline->value }}
                                @else
                                    0
                                @endif
                            </div>
                            <div class="col-md form-group">
                                {!! Form::number('target', $report->target, ['class' => 'form-control', 'id' => 'edit_target', 'required' => 'true']) !!}
                                {!! Form::label('target', 'Target', ['class' => 'form-control-placeholder', 'for' => 'edit_target']) !!}
                            </div>
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
                    <a class="btn btn-danger" href="/budgets/internal-revenue/delete">
                        Delete
                    </a>
                </div>
            </div>
        </div>
    </div>

@endSection