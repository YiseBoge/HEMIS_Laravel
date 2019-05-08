@extends('layouts.app')

@section('content')
    <div class="container w-75">
        <h1 class="font-weight-bold text-primary">Institutions</h1>
        <div class="card shadow-sm pt-3 mt-3">
            <div class="card-body">

                <table class="table border dataTable" width="100%"
                cellspacing="0" role="grid" aria-describedby="dataTable_info"
                style="width: 100%;">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-primary">Institution Name</th>
                            <th class="text-primary">Acronym</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($institutions)>0)
                        @foreach($institutions as $institution)
                          <tr>
                            <td>{{$institution->institution_name}}</td>
                            <td>{{$institution->acronym}}</td>
                            <td><a href="/institution/{{$institution->id}}/edit" class="btn btn-sm text-primary" data-toggle="modal" data-target="#editModal">Edit</a></td>
                            <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                          </tr>
                        @endforeach

                      @endif
                    </tbody>
                </table>


                {!! Form::open(['action'=>'Institution\InstitutionNamesController@store','method'=>'POST'])!!}

                <div class="form-row">
                    <div class="col-md-5">
                        <div class="form-group">

                          {{Form::text('institution_name','',['class'=>'form-control','placeholder'=>'Add New Institution'])}}


                        </div>

                    </div>
                    <div class="col-md-3 pl-md-5">
                        <div class="form-group">

                          {{Form::text('institution_acronym','',['class'=>'form-control','placeholder'=>'Acronym'])}}


                        </div>

                    </div>

                    <div class="col-md-1">
                      <div class="form-group">

                        {{Form::submit('Add',['class'=>'btn btn-outline-primary'])}}


                      </div>

                    </div>
                </div>

                {!! Form::close()!!}



            </div>
        </div>

    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTitle">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input class="form-control " id="institution_name_edit" type="text" value="Addis Ababa University">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
@endSection
