@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Research</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                                <form action="researches/0/approve" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="approveAll">
                                    <input type="hidden" name="department"
                                            value="{{$selected_department}}">
                                    <button type="submit"
                                            class="btn btn-sm btn-primary shadow-sm">
                                        Approve All Pending in Selected Department<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                    </button>
                                </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="researches/create">New
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
                    @endif

                    <div class="form-group row pt-3">
                        <div class="col form-group">
                            <select class="form-control" name="type" id="type" onchange="this.form.submit()">
                                @foreach ($types as $key => $value)
                                    @if ($value == $selected_type)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif

                                @endforeach
                            </select>
                            <label for="type" class="form-control-placeholder">
                                Research Type
                            </label>
                        </div>
                        <div class="col form-group">
                            <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                                @foreach ($completions as $key => $value)
                                    @if ($value == $selected_status)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif

                                @endforeach
                            </select>
                            <label for="status" class="form-control-placeholder" onchange="this.form.submit()">
                                Completion Status
                            </label>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                                   width="100%"
                                   cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                   style="width: 100%;">
                                <thead>
                                <tr role="row">
                                    <th style="min-width: 50px; width: 50px"></th>
                                    <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                        rowspan="1" colspan="1" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending"
                                        style="width: 151px;">Department
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1" aria-label="Age: activate to sort column ascending"
                                        style="width: 46px;">Researches
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1" aria-label="Age: activate to sort column ascending"
                                        style="width: 46px;">Male Teachers Participating
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Female Teachers Participating
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Female Lead Researchers
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Male Researchers From Other Institution
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Female Researchers From Other Institution
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Budget Allocated
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 99px;">Budget From External Fund
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="min-width: 99px;">Approval Status
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @if (count($researchs) > 0)
                                    @foreach ($researchs as $research)
                                        <tr role="row" class="odd"
                                            onclick="window.location='researches/{{$research->id}}'">
                                            <td class="text-center">
                                                    @if(Auth::user()->hasRole('College Super Admin'))
                                                        @if($research->approval_status == "Pending")
                                                            <form action="researches/{{$research->id}}/approve"
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
                                                        @if($research->approval_status != "Approved")
                                                            <div class="row px-1">
                                                                <div class="col px-0">
                                                                    <form class="p-0"
                                                                          action="researches/{{$research->id}}/edit"
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
                                                                          action="researches/{{$research->id}}"
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
                                            <td>{{$research->department->departmentName->department_name}}</td>
                                            <td>{{$research->number}}</td>
                                            <td>{{$research->male_teachers_participating_number}}</td>
                                            <td>{{$research->female_teachers_participating_number}}</td>
                                            <td>{{$research->female_researchers_number}}</td>
                                            <td>{{$research->male_researchers_other_number}}</td>
                                            <td>{{$research->female_researchers_other_number}}</td>
                                            <td>{{$research->budget_allocated}}</td>
                                            <td>{{$research->budget_from_externals}}</td>
                                            @if($research->approval_status == "Approved")
                                                <td class="text-success"><i
                                                            class="fas fa-check"></i> {{$research->approval_status}}
                                                </td>
                                            @elseif($research->approval_status == "Pending")
                                                <td class="text-warning"><i
                                                            class="far fa-clock"></i></i> {{$research->approval_status}}
                                                </td>
                                            @else
                                                <td class="text-danger"><i
                                                            class="fas fa-times"></i> {{$research->approval_status}}
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
        </div>
    </div>

@endsection
