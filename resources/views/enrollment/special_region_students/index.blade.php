@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Special Region Students Enrollment</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                           href="/enrollment/special-region-students/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <form action="" method="get">
                    <div class="form-group row pt-3">
                        <div class="col-md form-group">
                            <select class="form-control" name="region_type" id="region_type"
                                    onchange="this.form.submit()">
                                @if ($selected_type == "Emerging Regions")
                                    <option value="emerging_regions" selected>Emerging Regions</option>
                                    <option value="pastoral_regions">Pastoral Regions</option>
                                @else
                                    <option value="emerging_regions">Emerging Regions</option>
                                    <option value="pastoral_regions" selected>Pastoral Regions</option>
                                @endif

                            </select>
                            <label for="region_type" class="form-control-placeholder">
                                Region Type
                            </label>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="education_level" id="level"
                                    onchange="this.form.submit()">
                                @foreach ($education_levels as $key => $value)
                                    @if ($key == 'SPECIALIZATION')
                                        <option disabled value="{{$value}}">{{$value}}</option>
                                    @elseif($value == $selected_education_level)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="dormitory_service_type" class="form-control-placeholder">
                                Education Level
                            </label>
                        </div>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="program" id="program"
                                    onchange="this.form.submit()">
                                @foreach ($programs as $key => $value)
                                    @if ($value == $selected_program)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif

                                @endforeach
                            </select>
                            <label for="program" class="form-control-placeholder">
                                Program
                            </label>
                        </div>

                        <div class="col-md-4 form-group">
                            <select class="form-control" name="year_level" id="year_level"
                                    onchange="this.form.submit()">
                                @foreach ($year_levels as $key => $value)
                                    @if ($value == $selected_year)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif

                                @endforeach
                            </select>
                            <label for="year_level" class="form-control-placeholder">
                                Year Level
                            </label>
                        </div>

                    </div>
                </form>
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
                                style="width: 151px;">Region
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                                style="width: 46px;">Number of Male Students
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                                style="width: 99px;">Number of Female Students
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($enrollments) > 0)
                            @foreach ($enrollments as $enrollment)
                                <tr role="row" class="odd"
                                    onclick="window.location='normal/{{$enrollment->id}}'">
                                    <td class="pl-4">
                                        <div class="row">
                                            <div class="col pt-1">
                                                <a href="normal/{{$enrollment->id}}/edit"
                                                   class="text-primary mr-3"><i class="far fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <form class="p-0"
                                                      action="/enrollment/normal/{{$enrollment->id}}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit"
                                                            class="form-control form-control-plaintext text-danger p-0">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$enrollment->regionName->name}}</td>
                                    <td>{{$enrollment->male_number}}</td>
                                    <td>{{$enrollment->female_number}}</td>
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
