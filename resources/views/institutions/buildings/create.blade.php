@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        {!! Form::open(['action' => 'Institution\BuildingsController@store', 'method' => 'POST']) !!}
            <div class="row my-5">
                <div class="col-md">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Add a Building
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::text('building_name', null, ['class'=>'form-control', 'id'=>'create_building_name', 'required' => 'true']) !!}
                                        {!! Form::label('building_name', 'Building Name', ['class' => 'form-control-placeholder', 'for' => 'create_building_name']) !!}
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md">
                                            {!! Form::text('contractor_name', null, ['class'=>'form-control', 'id'=>'create_contractor_name', 'required' => 'true']) !!}
                                            {!! Form::label('contractor_name', 'Contractor\'s Name', ['class' => 'form-control-placeholder', 'for' => 'create_contractor_name']) !!}
                                        </div>
                                        <div class="form-group col-md">
                                            {!! Form::text('consultant_name', null, ['class'=>'form-control', 'id'=>'create_consultant_name', 'required' => 'true']) !!}
                                            {!! Form::label('consultant_name', 'Consultant\'s Name', ['class' => 'form-control-placeholder', 'for' => 'create_consultant_name']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md">
                                            {!! Form::date('date_started', null, ['class'=>'form-control', 'id'=>'create_date_started']) !!}
                                            {!! Form::label('date_started', 'Date Started', ['class' => 'form-control-placeholder', 'for' => 'create_date_started']) !!}
                                        </div>
                                        <div class="form-group col-md">
                                            {!! Form::date('date_completed', null, ['class'=>'form-control', 'id'=>'create_date_completed']) !!}
                                            {!! Form::label('date_completed', 'Date Completed', ['class' => 'form-control-placeholder', 'for' => 'create_date_completed']) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md">
                                            {!! Form::number('budget_allocated', null, ['class'=>'form-control', 'id'=>'create_budget_allocated']) !!}
                                            {!! Form::label('budget_allocated', 'Budget Allocated', ['class' => 'form-control-placeholder', 'for' => 'create_budget_allocated']) !!}
                                        </div>
                                        <div class="form-group col-md">
                                            {!! Form::number('financial_status', null, ['class'=>'form-control', 'id'=>'create_financial_status']) !!}
                                            {!! Form::label('financial_status', 'Financial Status', ['class' => 'form-control-placeholder', 'for' => 'create_financial_status']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::number('completion_status', null, ['class'=>'form-control', 'id'=>'create_completion_status']) !!}
                                        {!! Form::label('completion_status', 'Completion Status', ['class' => 'form-control-placeholder', 'for' => 'create_completion_status']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h5>Building Purposes</h5>
                                    <hr>
                                    @foreach($data['building_purposes'] as $purpose)
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