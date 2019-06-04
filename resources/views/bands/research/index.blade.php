@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Research</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-right">
                        <a class="btn btn-outline-primary btn-sm mb-0" href="researches/create">New Entry<i
                                    class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
                <form action="" method="get">
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
                                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">


                                        <table class="table table-bordered dataTable table-striped table-hover" id="dataTable" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 151px;">Band
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Researches
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Male Teachers Participating
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Teachers Participating
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Lead Researchers
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Male Researchers From Other Institution
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Researchers From Other Institution
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Budget Allocated
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Bedget From External Fund
                                        </th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($researchs) > 0)
                                            @foreach ($researchs as $research)
                                                <tr role="row" class="odd" onclick="window.location='normal/{{$research->id}}'">
                                                    <td class="pl-4">
                                                        <div class="row">
                                                            <div class="col pt-1">
                                                                <a href="normal/{{$research->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> </a>
                                                            </div>
                                                            <div class="col">
                                                                <form class="p-0" action="/research/normal/{{$research->id}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="form-control form-control-plaintext text-danger p-0">
                                                                            <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>  
                                                    <td>{{$research->band->bandName->band_name}}</td>
                                                    <td>{{$research->number}}</td>
                                                    <td>{{$research->male_teachers_participating_number}}</td>
                                                    <td>{{$research->female_teachers_participating_number}}</td>
                                                    <td>{{$research->female_researchers_number}}</td>
                                                    <td>{{$research->male_researchers_other_number}}</td>
                                                    <td>{{$research->female_researchers_other_number}}</td>
                                                    <td>{{$research->budget_allocated}}</td>
                                                    <td>{{$research->budget_from_externals}}</td>

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
