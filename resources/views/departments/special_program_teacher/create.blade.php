@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        {!! Form::open(['action' => 'Department\SpecialProgramTeacherController@store', 'method' => 'POST', 'class' => 'w-100']) !!}
        @csrf
        <div class="row my-5">
            <div class="col">
                <fieldset class="card shadow h-100">
                    <div class="card-header text-primary">
                        Special Program Teachers
                    </div>
                    <div class="card-body px-4">

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                {!! Form::select('program_type', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramTypes') , $program_type , ['class' => 'form-control', 'id' => 'add_program_type']) !!}
                                {!! Form::label('add_program_type', 'Program Type', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col form-group">
                                {!! Form::select('program_status', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramStats') , $program_status , ['class' => 'form-control', 'id' => 'add_program_status']) !!}
                                {!! Form::label('add_program_status', 'Program Status', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="number" id="male_number" name="male_number" class="form-control" required
                                       value="{{ old('male_number') }}">
                                <label class="form-control-placeholder" for="male_number">Male Teachers</label>
                            </div>

                            <div class="col form-group">
                                <input type="number" id="female_number" name="female_number" class="form-control"
                                       required value="{{ old('female_number') }}">
                                <label class="form-control-placeholder" for="female_number">Female Teachers</label>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>

        </div>

        <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        {!! Form::close() !!}
    </div>
@endsection

