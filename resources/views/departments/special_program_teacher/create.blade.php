@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--  Disabled Students Form  -->
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
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
                                    {!! Form::select('program_type', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramTypes') , $data['program_type'] , ['class' => 'form-control', 'id' => 'add_program_type']) !!}
                                    {!! Form::label('program_type', 'Program Type', ['class' => 'form-control-placeholder', 'for' => 'add_program_type']) !!}
                                </div>
                                <div class="col form-group">
                                    {!! Form::select('program_status', \App\Models\Department\SpecialProgramTeacher::getEnum('ProgramStats') , $data['program_status'] , ['class' => 'form-control', 'id' => 'add_program_status']) !!}
                                    {!! Form::label('program_status', 'Program Status', ['class' => 'form-control-placeholder', 'for' => 'add_program_status']) !!}
                                </div>
                            </div>
                         
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="male_number" name="male_number" class="form-control" required>
                                    <label class="form-control-placeholder" for="male_number">Number of Male Teachers</label>
                                </div>

                                <div class="col form-group">
                                    <input type="text" id="female_number" name="female_number" class="form-control" required>
                                    <label class="form-control-placeholder" for="female_number">Number of Female Teachers</label>
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

