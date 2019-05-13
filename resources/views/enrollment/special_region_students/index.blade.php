@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Special Region Students Enrollment</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="special-regions/create">New Entry<i
                                        class="fas fa-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                        
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="region_type" id="region_type">
                                        <option value="emerging_regions">Emerging Regions</option>
                                        <option value="pastoral_regions">Pastoral Regions</option>
                                    </select>
                                    <label for="region_type" class="form-control-placeholder">
                                            Region Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="region" id="region">
                                        @foreach ($regions as $region)
                                            <option value="{{$region->name}}">{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="region" class="form-control-placeholder">
                                            Region
                                    </label>
                                </div>
                        </div>
                       
                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                
                                <select class="form-control" name="program" id="program">
                                    @foreach ($programs as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <label for="service_type" class="form-control-placeholder">
                                        Program
                                    </label>
                            </div>
        
                            <div class="col form-group">
                                
                                <select class="form-control" name="year_level" id="year_level">
                                    @foreach ($year_levels as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <label for="dormitory_service_type" class="form-control-placeholder">
                                        Year Level
                                    </label>
                            </div>
        
                        </div>
                            <div class="row">
                                <div class="col text-right">
                                    <a class="btn btn-outline-primary btn-sm mb-0" href="normal/">Reload</a>
                                </div>
                            </div>
                            <hr>                        
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable table-striped table-hover" id="dataTable" width="100%"
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
                                                <tr role="row" class="odd" onclick="window.location='normal/{{$enrollment->id}}'">
                                                    <td class="pl-4">
                                                        <div class="row">
                                                            <div class="col pt-1">
                                                                <a href="normal/{{$enrollment->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> </a>
                                                            </div>
                                                            <div class="col">
                                                                <form class="p-0" action="/enrollment/normal/{{$enrollment->id}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="form-control form-control-plaintext text-danger p-0">
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
            </div>
        </div>
    </div>
    
@endsection
