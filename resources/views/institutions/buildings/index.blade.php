@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Buildings</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                                <form action="normal/0/approve" method="POST">
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
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/enrollment/normal/create">New
                                Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif


                {!! Form::open(['action' => 'College\BuildingsController@index', 'method' => 'get']) !!}
                    <div class="form-row">
                        <div class="col-md form-group">
                {!! Form::select('building_purpose', $building_purposes, $current_purpose, ['class' => 'form-control', 'onchange' => 'this.form.submit()', 'id' => 'select_building_purpose'])!!}
                {!! Form::label('select_building_purpose', 'Building Purpose', ['class' => 'form-control-placeholder']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}


                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                           width="100%"
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
                                Contractor's Name
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending">
                                Consultant's Name
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
                                Budget Allocated
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending">
                                Financial Status
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending">
                                Completion Status
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="min-width: 99px;">Approval Status
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($buildings as $building)
                            <tr role="row" class="odd">
                                    <td class="text-center">
                                            @if(Auth::user()->hasRole('College Super Admin'))
                                                @if($building->approval_status == "Pending")
                                                    <form action="buildings/{{$building->id}}/approve"
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
                                                @if($building->approval_status != "Approved")
                                                    <div class="row px-1">
                                                        <div class="col px-0">
                                                            <form class="p-0"
                                                                  action="buildings/{{$building->id}}/edit"
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
                                                            <form class="p-0"
                                                                  action="buildings/{{$building->id}}"
                                                                  method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method"
                                                                       value="DELETE">
                                                                <button type="submit"
                                                                        class="btn btn-danger btn-circle text-white btn-sm mx-0"
                                                                        style="opacity:0.80"
                                                                        data-toggle="tooltip" title="Delete">
                                                                    <i class="fas fa-trash fa-sm"
                                                                       style="opacity:0.75"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                <td class="sorting_1">{{$building->building_name}}</td>
                                <td>{{$building->date_started}}</td>
                                <td>{{$building->contractor_name}}</td>
                                <td>{{$building->consultant_name}}</td>
                                <td>{{$building->date_completed}}</td>
                                <td>{{$building->budget_allocated}}</td>
                                <td>{{$building->financial_status}}</td>
                                <td>{{$building->completion_status}}%</td>
                                @if($building->approval_status == "Approved")
                                    <td class="text-success"><i
                                                class="fas fa-check"></i> {{$building->approval_status}}
                                    </td>
                                @elseif($building->approval_status == "Pending")
                                    <td class="text-warning"><i
                                                class="far fa-clock"></i></i> {{$building->approval_status}}
                                    </td>
                                @else
                                    <td class="text-danger"><i
                                                class="fas fa-times"></i> {{$building->approval_status}}
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

@endsection
