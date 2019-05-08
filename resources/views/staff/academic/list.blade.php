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
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_length" id="dataTable_length"><label>Show <select
                                            name="dataTable_length" aria-controls="dataTable"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input
                                            type="search" class="form-control form-control-sm" placeholder=""
                                            aria-controls="dataTable"></label></div>
                            </div>
                            <div class="col-sm-12 col-md-2 text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="academic/create">Add Staff<i
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
                                        <th width="75"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 15%;">Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Job Title
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Dedication
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Employment Type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            >Is Expatriate
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            >Salary
                                        </th>  
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Academic Level
                                        </th>                                        
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Field of Study
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            >Staff Rank
                                        </th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @if (count($staffs) > 0)
                                        @foreach ($staffs as $staff)
                                            <tr role="row" class="odd" onclick="window.location='academic/{{$staff->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="academic/{{$staff->id}}/edit" class="text-muted mr-3"><i class="far fa-edit"></i> </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0" action="/staff/academic/{{$staff->id}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="form-control form-control-plaintext text-muted p-0">
                                                                        <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </td>  
                                                <td class="sorting_1">{{$staff->general->name}}</td>
                                                <td>{{$staff->general->job_title}}</td>
                                                <td>{{$staff->general->dedication}}</td>
                                                <td>{{$staff->general->employment_type}}</td>
                                                <td>{{$staff->general->is_expatriate}}</td>
                                                <td>{{$staff->general->salary}}</td> 
                                                <td>{{$staff->general->academic_level}}</td>                                            
                                                <td>{{$staff->field_of_study}}</td>
                                                <td>{{$staff->staffRank}}</td>                                                                                          
                                            </tr>
                                        @endforeach
                                      @else
                                          
                                      @endif 

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="dataTable_info" role="status"
                                        aria-live="polite">Showing 1 to 10 of 57 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled"
                                            id="dataTable_previous"><a href="#" aria-controls="dataTable"
                                                                        data-dt-idx="0" tabindex="0"
                                                                        class="page-link">Previous</a></li>
                                        <li class="paginate_button page-item active"><a href="#"
                                                                                        aria-controls="dataTable"
                                                                                        data-dt-idx="1"
                                                                                        tabindex="0"
                                                                                        class="page-link">1</a>
                                        </li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                    aria-controls="dataTable"
                                                                                    data-dt-idx="2" tabindex="0"
                                                                                    class="page-link">2</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                    aria-controls="dataTable"
                                                                                    data-dt-idx="3" tabindex="0"
                                                                                    class="page-link">3</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                    aria-controls="dataTable"
                                                                                    data-dt-idx="4" tabindex="0"
                                                                                    class="page-link">4</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                    aria-controls="dataTable"
                                                                                    data-dt-idx="5" tabindex="0"
                                                                                    class="page-link">5</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                                                    aria-controls="dataTable"
                                                                                    data-dt-idx="6" tabindex="0"
                                                                                    class="page-link">6</a></li>
                                        <li class="paginate_button page-item next" id="dataTable_next"><a
                                                href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0"
                                                class="page-link">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
