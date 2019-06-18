@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Reports</div>
            <div class="card-body px-5">
                <div class="row my-3">
                    <div class="col-sm text-right">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="">Print to PDF<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable table-hover"
                                           id="dataTable"
                                           width="100%"
                                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                           style="width: 100%;">

                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Policy
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="KPI: activate to sort column ascending">Key
                                                Performance Indicators (KPI)
                                            </th>
                                            @foreach($years as $year)
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Year: activate to sort column ascending">{{ $year->year }}
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
                                                            change
                                                        </td>
                                                        <td>
                                                            <a href="" class="text-primary mr-3" data-toggle="tooltip"
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