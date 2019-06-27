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
        {!! Form::open(['action' => 'Department\AcademicStaffController@store', 'method' => 'POST', 'class' => 'w-100']) !!}
        @csrf
        <div class="row my-5">
            <div class="col">
                <fieldset class="card shadow h-100">
                    <div class="card-header text-primary">
                        Academic Staff
                    </div>
                    <div class="card-body px-4">
                        <div class="form-group row pt-3">
                            <div class="form-group col-md-6">
                                {!! Form::select('rank_level', \App\Models\Department\AcademicStaff::getEnum('StaffRanks') , $data['rank_level'] , ['class' => 'form-control', 'id' => 'add_rank_level', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('add_rank_level', 'Rank Level', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="male_number" name="male_number" class="form-control" required>
                                <label class="form-control-placeholder" for="male_number">Number of Male
                                    Staff</label>
                            </div>

                            <div class="col form-group">
                                <input type="text" id="female_number" name="female_number" class="form-control"
                                       required>
                                <label class="form-control-placeholder" for="female_number">Number of Female
                                    Staff</label>
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

