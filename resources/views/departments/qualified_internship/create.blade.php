@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/student/qualified-internship" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                        Qualified Internship
                        </div>
                        <div class="card-body px-4">

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="type" id="type">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$key}}" {{ (old('type') == $key ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Sponsor Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value="{{ old('male_number') }}">
                                    <label class="form-control-placeholder" for="male_number">Number of
                                        Male Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number"
                                           class="form-control"
                                           required value="{{ old('female_number') }}">
                                    <label class="form-control-placeholder" for="female_number">Number of
                                        Female Students</label>
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

