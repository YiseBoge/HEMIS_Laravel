@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        {!! Form::open(['action' => 'College\BuildingsController@store', 'method' => 'POST']) !!}
        <div class="row my-5">
            <div class="col-md">
                <fieldset class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add a Building</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::text('building_name', old('building_name'), ['class'=>'form-control', 'id'=>'create_building_name', 'required' => 'true']) !!}
                                    {!! Form::label('create_building_name', 'Building Name', ['class' => 'form-control-placeholder']) !!}
                                </div>

                                <div class="row">
                                    <div class="form-group col-md">
                                        {!! Form::text('contractor_name', old('contractor_name'), ['class'=>'form-control', 'id'=>'create_contractor_name', 'required' => 'true']) !!}
                                        {!! Form::label('create_contractor_name', 'Contractor\'s Name', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                    <div class="form-group col-md">
                                        {!! Form::text('consultant_name', old('consultant_name'), ['class'=>'form-control', 'id'=>'create_consultant_name', 'required' => 'true']) !!}
                                        {!! Form::label('create_consultant_name', 'Consultant\'s Name', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md">
                                        {!! Form::date('date_started', old('date_started'), ['class'=>'form-control', 'id'=>'create_date_started']) !!}
                                        {!! Form::label('create_date_started', 'Date Started', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                    <div class="form-group col-md">
                                        {!! Form::date('date_completed', old('date_completed'), ['class'=>'form-control', 'id'=>'create_date_completed']) !!}
                                        {!! Form::label('create_date_completed', 'Date Completed', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md">
                                        {!! Form::number('budget_allocated', old('budget_allocated'), ['class'=>'form-control', 'id'=>'create_budget_allocated', 'required']) !!}
                                        {!! Form::label('create_budget_allocated', 'Budget Allocated', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                    <div class="form-group col-md">
                                        {!! Form::number('financial_status', old('financial_status'), ['class'=>'form-control', 'id'=>'create_financial_status', 'required']) !!}
                                        {!! Form::label('create_financial_status', 'Financial Status', ['class' => 'form-control-placeholder']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::number('completion_status', old('completion_status'), ['class'=>'form-control', 'id'=>'create_completion_status', 'required']) !!}
                                    {!! Form::label('create_completion_status', 'Completion Status', ['class' => 'form-control-placeholder']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5>Building Purposes</h5>
                                <hr>
                                @foreach($building_purposes as $purpose)
                                    <div class="form-check m-2 mt-0">
                                        {!! Form::checkbox('building_purposes[]', $purpose,  null, ['id' => "select_$purpose", 'class' => 'form-check-input']) !!}
                                        {!! Form::label('building_purposes', $purpose, ['class' => 'form-check-label', 'for' => "select_$purpose"]) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        {!! Form::submit('Save', ['class' => 'btn btn-outline-secondary float-right my-1']) !!}
        {!! Form::close() !!}
    </div>
@endsection