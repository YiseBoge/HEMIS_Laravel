@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/department/teachers" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Teachers
                        </div>
                        <div class="card-body px-4">

                            <div class="form-group row pt-3">


                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="education_level" id="education_level">
                                        @foreach ($education_levels as $key => $value)
                                            <option value="{{$value}}" {{ (old('education_level') == $key ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="education_level" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                            </div>


                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="citizenship" name="citizenship" class="form-control" required
                                           value="{{ old('citizenship') }}">
                                    <label class="form-control-placeholder" for="citizenship">Citizenship</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value="{{ old('male_number') }}">
                                    <label class="form-control-placeholder" for="male_number">Male Teachers</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required value="{{ old('female_number') }}">
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Teachers</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

            </div>

            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

