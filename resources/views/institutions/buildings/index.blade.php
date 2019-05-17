@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Academic Staff</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row my-3">
                            <div class="col-sm">
                                {!! Form::open(['action' => 'Institution\BuildingsController@index', 'method' => 'get']) !!}
                                    {!! Form::select('building_purpose', $data['building_purposes'], $data['current_purpose'], ['class' => 'form-control', 'onchange' => 'this.form.submit()', 'id' => 'select_building_purpose'])!!}
                                    {!! Form::label('building_purpose', 'Building Purpose', ['class' => 'form-control-placeholder', 'for' => 'select_building_purpose']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="col-sm text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="/institution/buildings/create">Add<i
                                            class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable" width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Building Name
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Date Started
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Date Completed
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Contractor's Name
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Consultant's Name
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending">
                                            Budget Allocated
                                        </th><th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                                 rowspan="1" colspan="1" aria-sort="ascending">
                                            Financial Status ??
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data['buildings'] as $building)
                                            <tr role="row" class="odd">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="institution/buildings/{{$building->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0" action="/institution/non-admin/{{$building->id}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="sorting_1">{{$building->building_name}}</td>
                                                <td>{{$building->date_started}}</td>
                                                <td>{{$building->date_completed}}</td>
                                                <td>{{$building->contractor_name}}</td>
                                                <td>{{$building->consultant_name}}</td>
                                                <td>{{$building->budget_allocated}}</td>
                                                <td>{{$building->financial_status}}</td>
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

@endsection