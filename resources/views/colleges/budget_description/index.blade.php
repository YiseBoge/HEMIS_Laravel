@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <h1 class="font-weight-bold text-primary">Budget Descriptions</h1>
        <div class="card shadow pt-3 mt-3">
            <div class="card-body">

                <table class="table border dataTable" width="100%"
                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                       style="width: 100%;">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-primary">Description</th>
                        <th class="text-primary">Code</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($budgetDescriptions)>0)
                        @foreach($budgetDescriptions as $budgetDescription)
                            <tr>
                                <td>{{$budgetDescription->description}}</td>
                                <td>{{$budgetDescription->budget_code}}</td>
                                <td><a href="#" class="btn btn-sm text-primary" data-toggle="modal"
                                       data-target="#editModal">Edit</a></td>
                                <td><a href="#" class="btn btn-sm text-primary">Delete</a></td>
                            </tr>
                        @endforeach

                    @endif
                    </tbody>
                </table>
                {!! Form::open(['action'=>'College\BudgetDescriptionsController@store','method'=>'POST'])!!}

                <div class="form-row">
                    <div class="col-md-5">
                        <div class="form-group">

                            {{Form::text('description','',['class'=>'form-control','placeholder'=>'Add New Budget Description'])}}


                        </div>

                    </div>
                    <div class="col-md-3 pl-md-5">
                        <div class="form-group">
                            {{Form::text('budget_code','',['class'=>'form-control','placeholder'=>'Code'])}}
                        </div>

                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            {{Form::submit('Add',['class'=>'btn btn btn-primary btn-sm mb-0 shadow-sm'])}}
                        </div>

                    </div>
                </div>

                {!! Form::close()!!}


            </div>
        </div>

    </div>

    @if ($page_name == 'administer.budget-description.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/budget-description" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">


                        <input class="form-control " id="department_name_edit" type="text" value="Computer Science">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endSection
