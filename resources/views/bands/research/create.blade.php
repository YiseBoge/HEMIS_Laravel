@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <!--  Disabled Students Form  -->
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form class="pb-5" action="/institution/researches" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Research
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">

                                <div class="col form-group">
                                    <select class="form-control" name="type" id="type">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Research Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="status" id="status">
                                        @foreach ($completions as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="status" class="form-control-placeholder">
                                        Completion Status
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="number" name="number" class="form-control" required>
                                    <label class="form-control-placeholder" for="number">Number of Researches</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Researchers</label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="budget" name="budget" class="form-control" required>
                                    <label class="form-control-placeholder" for="budget">Budget Allocated</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="external_budget" name="external_budget"
                                           class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="external_budget">Budget From External
                                        Fund</label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_participating_number" name="male_participating_number"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="male_participating_number">
                                        Male Teachers Participating</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_participating_number"
                                           name="female_participating_number" class="form-control" required>
                                    <label class="form-control-placeholder" for="female_participating_number">
                                        Female Teachers Participating</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="other_male_number" name="other_male_number"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="other_male_number">Male
                                        Researchers From Other Institution</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="other_female_number" name="other_female_number"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="other_female_number">Female
                                        Researchers From Other Institution</label>
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

