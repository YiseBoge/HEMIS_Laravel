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
        {!! Form::open(['action' => 'Department\UpgradingStaffController@store', 'method' => 'POST', 'class' => 'w-100']) !!}
        @csrf
        <div class="row my-5">
            <div class="col">
                <fieldset class="card shadow h-100">
                    <div class="card-header text-primary">
                        Upgrading Staff
                    </div>
                    <div class="card-body px-4">

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                {!! Form::select('education_level', \App\Models\Department\UpgradingStaff::getEnum('EducationLevels') , $education_level , ['class' => 'form-control', 'id' => 'add_education_level', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('education_level', 'Education Level', ['class' => 'form-control-placeholder', 'for' => 'education_level']) !!}
                            </div>
                            <div class="col form-group">
                                {!! Form::select('study_place', \App\Models\Department\UpgradingStaff::getEnum('StudyPlaces') , $study_place , ['class' => 'form-control', 'id' => 'add_study_place', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('study_place', 'Study Place', ['class' => 'form-control-placeholder', 'for' => 'add_study_place']) !!}
                            </div>
                        </div>
              
                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male
                                    Teachers</label>
                            </div>

                            <div class="col form-group">
                                <input type="text" id="female_number" name="female_number" class="form-control"
                                       required>
                                <label class="form-control-placeholder" for="female_number">Number of Female
                                    Teachers</label>
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

