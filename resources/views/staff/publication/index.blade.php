@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Publications and Patents</h6>
            </div>
            <div class="card-body">
                <form action="/publication/{{$publications_and_patents->id}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="container row mt-3 px-5">
                        <div class="col-md-8">
                            <div class="text-sm font-weight-bold text-uppercase mb-1">Number of Publications By
                                Postgraduate Students
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext"
                                       name="student_publications"
                                       value="{{$publications_and_patents->student_publications}}">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-sm font-weight-bold text-uppercase mb-1">Number of Patents Earned</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="patents"
                                       value="{{$publications_and_patents->patents}}">

                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-sm btn-outline-primary float-right my-1 mr-5" value="Save">
                </form>
                <hr class="mt-5">
                <div class="table-responsive mt-5">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="text-sm font-weight-bold text-uppercase mb-1">Publications By Academic Staff with
                            Rank of Associate and Full Professor
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="publication/create">New Entry<i
                                            class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable"
                                       width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 80px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 30%;">Author
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 30%;">Title
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                        >Date of Publication
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($publications) > 0)
                                        @foreach ($publications as $publication)
                                            <tr role="row" class="odd"
                                                onclick="window.location='publication/{{$publication->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="publication/{{$publication->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0" action="/publication/{{$publication->id}}"
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
                                                <td class="sorting_1">{{$publication->academicStaff->general->name}}</td>
                                                <td>{{$publication->title}}</td>
                                                <td>{{$publication->date_of_publication}}</td>
                                            </tr>
                                        @endforeach
                                    @else

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
