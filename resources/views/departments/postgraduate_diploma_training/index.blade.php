@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Post Graduate Diploma Training</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <form action="postgraduate-diploma-training/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <input type="hidden" name="department"
                                       value="{{$selected_department}}">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm" {{count($trainings) == 0 ? 'disabled' : ''}}>
                                    Approve All Pending in Selected Department<i
                                            class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                               href="postgraduate-diploma-training/create">New
                                Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif

                <form action="" method="get">
                    @if(Auth::user()->hasRole('College Super Admin'))
                        <div class="form-group row pt-3">
                            <div class="col-md form-group">
                                <select class="form-control" name="department" id="department"
                                        onchange="this.form.submit()">
                                    @foreach ($departments as $department)
                                        @if ($department->id == $selected_department)
                                            <option value="{{$department->id}}"
                                                    selected>{{$department->department_name}}</option>
                                        @else
                                            <option value="{{$department->id}}">{{$department->department_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="department" class="form-control-placeholder">
                                    Department
                                </label>
                            </div>
                        </div>
                    @else

                        <div class="form-group row pt-3">
                            <div class="col-md-6 form-group">
                                <select class="form-control" name="type" id="type" onchange="this.form.submit()">
                                    @foreach ($types as $key => $value)
                                        @if ($value == "Normal" && $selected_type == 0)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @elseif ($value == "School Leaders" && $selected_type == 1)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif

                                    @endforeach
                                </select>
                                <label for="type" class="form-control-placeholder">
                                    Staff Type
                                </label>
                            </div>
                        </div>
                    @endif
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th style="min-width: 50px; width: 50px"></th>
                            @if(Auth::user()->hasRole('College Super Admin'))
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >Teacher Type
                                </th>
                            @endif
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending"
                            >Program
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                            >Male Teachers
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                            >Female Teachers
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" style="min-width: 95px"
                                aria-label="Start date: activate to sort column ascending"
                            >Approval Status
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($trainings) > 0)
                            @foreach ($trainings as $training)
                                <tr role="row" class="odd">
                                    @if(Auth::user()->hasRole('College Super Admin'))
                                        <td class="text-center">
                                            @if($training->approval_status == "Pending")
                                                <form action="postgraduate-diploma-training/{{$training->id}}/approve"
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
                                        </td>
                                        <td>{{$training->is_lead ? "School Leaders" : "Normal"}}</td>
                                    @else
                                        <td class="text-center">
                                            @if(!in_array($training->approval_status, ["Approved", "College Approved"]))
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="postgraduate-diploma-training/{{$training->id}}/edit"
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
                                                                style="opacity:0.80" data-id="{{$training->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{$training->department->college->education_program}}</td>
                                    <td>{{$training->number_of_male_students}}</td>
                                    <td>{{$training->number_of_female_students}}</td>
                                    @if($training->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check-double"></i> {{$training->approval_status}}
                                        </td>
                                    @elseif($training->approval_status == "College Approved")
                                        <td class="text-primary"><i
                                                    class="fas fa-check"></i> {{$training->approval_status}}
                                        </td>
                                    @elseif($training->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$training->approval_status}}
                                        </td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$training->approval_status}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
