@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
    <form class="pb-5" action="/institution/researches/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                           Edit Research Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">

                                <div class="col form-group">
                                    <select class="form-control" name="type" id="type">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$value}}" {{ (old('type') == $value ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Research Type
                                    </label>
                                    {{-- <label class="" for="research_type">Research Type</label>
                                    <input type="text" id="research_type" name="research_type" class="form-control" required disabled
                                        value="{{$research->type}}"> --}}
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="status" id="status">
                                        @foreach ($completions as $key => $value)
                                            <option value="{{$value}}" {{ (old('status') == $value ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="status" class="form-control-placeholder">
                                        Completion Status
                                    </label>
                                    {{-- <label class="" for="completion_status">Completion Status</label>
                                    <input type="text" id="completion_status" name="completion_status" class="form-control" required disabled
                                        value="{{$research->status}}"> --}}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="number" name="number" class="form-control" required
                                           value="{{ $research->number }}">
                                    <label class="form-control-placeholder" for="number">Number of Researches</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           value="{{$research->female_researchers_number}}"
                                           required>
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Researchers</label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="budget" name="budget" class="form-control" required
                                           value="{{$research->budget_allocated }}">
                                    <label class="form-control-placeholder" for="budget">Budget Allocated</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="external_budget" name="external_budget"
                                           class="form-control" value="{{$research->budget_from_externals}}"
                                           required>
                                    <label class="form-control-placeholder" for="external_budget">Budget From External
                                        Fund</label>
                                </div>

                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_participating_number" name="male_participating_number"
                                           value="{{$research->male_teachers_participating_number}}"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="male_participating_number">
                                        Male Teachers Participating</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_participating_number"
                                           value="{{ $research->female_teachers_participating_number}}"
                                           name="female_participating_number" class="form-control" required>
                                    <label class="form-control-placeholder" for="female_participating_number">
                                        Female Teachers Participating</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="other_male_number" name="other_male_number"
                                           value="{{ $research->male_researchers_other_number }}"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="other_male_number">Male
                                        Researchers From Other Institution</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="other_female_number" name="other_female_number"
                                           value="{{$research->female_researchers_other_number }}"
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

