@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">University Policy Performance report Card</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col-sm-6 text-left">
                        @if (Auth::user()->currentInstance != null && Auth::user()->hasRole('University Admin'))
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/report/generate-institution-report">Update
                                Current Year<i
                                        class="fas fa-sync-alt text-white-50 fa-sm ml-2"></i></a>
                        @else
                            {!! Form::open(['action' => 'Report\InstitutionReportsController@index', 'method' => 'GET']) !!}
                            {!! Form::select('institution_name', $institution_names, $ind  , ['class' => 'form-control', 'id' => 'institution_name', 'onchange' => 'this.form.submit()']) !!}
                            {!! Form::label('institution_name', 'University', ['class' => 'form-control-placeholder']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm mb-0 shadow-sm" id="exporter">
                            <i class="fas fa-download text-white-50 fa-sm mr-2"></i>Export to Excel
                        </button>
                        <button type="button" class="btn btn-primary btn-sm mb-0 shadow-sm ml-1"
                                onclick="printJS({ printable: 'printable', type: 'html', css: '/css/app.css', documentTitle: 'KPI (Key Performance Indicators) - {{$institution_name}}', ignoreElements: ['unprint'] }) ">
                            <i class="fas fa-download text-white-50 fa-sm mr-2"></i>Print to PDF
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm text-left">
                        <p>
                            <span class="font-weight-bold">Name of higher education institution:</span> {{$institution_name}}
                        </p>
                        {{--                        <p><span class="font-weight-bold">Responsible:</span> _____________________________ </p>--}}
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
                                @if (Auth::user()->hasRole('University Admin'))
                                    <th class="sorting hide-print" tabindex="0" aria-controls="dataTable"
                                        rowspan="1"
                                        colspan="1" aria-label="Year: activate to sort column ascending"
                                        id="unprint">
                                    </th>
                                @endif

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($reports as $policy => $descriptions)
                                <tr>
                                    <th class="bg-gray-200 font-weight-bold h5"
                                        colspan="{{ count($years) + 5 }}">
                                        {{ $policy }}
                                    </th>
                                </tr>
                                @foreach($descriptions as $description => $kpis)
                                    <tr>
                                        <td style="min-width:225px;" rowspan="{{ count($kpis) + 1 }}">
                                            {{ $description }}
                                        </td>

                                    </tr>
                                    @foreach($kpis as $kpi)
                                        <tr style="height: 100px;">
                                            <td style="min-width:275px;">
                                                {{ $kpi->kpi }}
                                            </td>
                                            @foreach($kpi->reportYearValues()->where('institution_name_id', $institution_name->id)->orderBy('year')->get() as $yearValue)
                                                <td>
                                                    {{ round($yearValue->value, 3) }}%
                                                </td>
                                            @endforeach
                                            <td class="text-primary text-center">
                                                {{ $kpi->target($institution_name)->value }}
                                            </td>
                                            <td class="text-center" style="min-width:115px;">
                                                @if($kpi->change($institution_name) > 0)
                                                    <p class="text-success">{{$kpi->change($institution_name)}}% <i
                                                                class="fa fa-caret-up d-inline-block ml-2"></i>
                                                    </p>
                                                @elseif($kpi->change($institution_name))
                                                    <p class="text-danger">{{$kpi->change($institution_name)}}%<i
                                                                class="fa fa-caret-down d-inline-block ml-2"></i>
                                                    </p>
                                                @else
                                                    <p class="text-warning">{{$kpi->change($institution_name)}}%</p>
                                                @endif
                                            </td>
                                            @if (Auth::user()->hasRole('University Admin'))
                                                <td class="hide-print" id="unprint">
                                                    <a href="/institution-report/{{ $kpi->id }}/edit"
                                                       class="btn btn-primary btn-circle text-white btn-sm mx-0"
                                                       style="opacity:0.80"
                                                       data-toggle="tooltip" title="Edit Target">
                                                        <i class="fas fa-pencil-alt fa-sm"
                                                           style="opacity:0.75"></i>
                                                    </a>
                                                </td>
                                            @endif

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

    @if ($page_name == 'report.institution_report_card.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Report\InstitutionReportsController@update', $target->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Set Target</h5>
                        <a href="/institution-report" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body px-5">

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

                        <div class="row my-2">
                            <div class="col-md text-center">
                                @if($report->change($institution_name) > 0)
                                    <p class="h3 text-success">{{$report->change()}}% <i
                                                class="fa fa-caret-up d-inline-block ml-2"></i></p>
                                @elseif($report->change($institution_name) < 0)
                                    <p class="h3 text-danger">{{$report->change($institution_name)}}%<i
                                                class="fa fa-caret-down d-inline-block ml-2"></i></p>
                                @else
                                    <p class="h3 text-warning">{{$report->change($institution_name)}}%</p>
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
                                {!! Form::number('target', $target->value , ['class' => 'form-control', 'id' => 'edit_target', 'required' => 'true',  'step' => 'any']) !!}
                                {!! Form::label('edit_target', 'Target', ['class' => 'form-control-placeholder', 'for' => 'edit_target']) !!}
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
@endSection