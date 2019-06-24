@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Policy Performance report Card</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col-sm-4 text-left">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/report/generate-full-report">Update
                            Current Year<i
                                    class="fas fa-sync-alt text-white-50 fa-sm ml-2"></i></a>
                    </div>
                    <div class="col-sm-8 text-right">
                        <button type="button" class="btn btn-primary btn-sm mb-0 shadow-sm" id="exporter">
                            <i class="fas fa-download text-white-50 fa-sm mr-2"></i>Export to Excel
                        </button>
                        <button type="button" class="btn btn-primary btn-sm mb-0 shadow-sm ml-1"
                                onclick="printJS({ printable: 'printable', type: 'html', css: '/css/app.css', documentTitle: 'KPI (Key Performance Indicators) - MoSHE', ignoreElements: ['unprint'] }) ">
                            <i class="fas fa-download text-white-50 fa-sm mr-2"></i>Print to PDF
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm text-left">
                        <p><span class="font-weight-bold">Policy Owner/Responsible Implementer:</span> Ministry of
                            Science and Higher Education</p>
                        <p><span class="font-weight-bold">Responsible:</span> Core management team of MoSHE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <table id="printable"
                               class="table table-bordered responsive"
                               width="100%"
                               cellspacing="0" role="grid" aria-describedby="dataTable_info">

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
                                    %
                                </th>
                                <th class="sorting hide-print" tabindex="0" aria-controls="dataTable"
                                    rowspan="1"
                                    colspan="1" aria-label="Year: activate to sort column ascending"
                                    id="unprint">
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
                                        <td style="min-width:225px;" rowspan="{{ count($kpis) + 1 }}">
                                            {{ $description }}
                                        </td>

                                    </tr>
                                    @foreach($kpis as $kpi)
                                        <tr style="height: 150px;">
                                            <td style="min-width:275px;">
                                                {{ $kpi->kpi }}
                                            </td>
                                            @foreach($kpi->reportYearValues->sortBy('year') as $yearValue)
                                                <td>
                                                    {{ round($yearValue->value, 2) }}
                                                </td>
                                            @endforeach
                                            <td class="text-primary">
                                                {{ $kpi->target }}
                                            </td>
                                            <td class="text-center" style="min-width:115px;">
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
                                            <td class="hide-print" id="unprint">
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

    @if ($page_name == 'report.report_card.edit')
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
                                @if($report->change() > 0)
                                    <p class="h3 text-success">{{$report->change()}}% <i
                                                class="fa fa-caret-up d-inline-block ml-2"></i></p>
                                @elseif($report->change() < 0)
                                    <p class="h3 text-danger">{{$report->change()}}%<i
                                                class="fa fa-caret-down d-inline-block ml-2"></i></p>
                                @else
                                    <p class="h3 text-warning">{{$report->change()}}%</p>
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
                                {!! Form::number('target', $report->target, ['class' => 'form-control', 'id' => 'edit_target', 'required' => 'true',  'step' => 'any']) !!}
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