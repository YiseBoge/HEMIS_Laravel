@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/staff/ict" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add ICT Staff Member</h3>

            <fieldset id="academic-staff" class="card shadow">
                <div class="card-header text-primary">
                    ICT Staff Information
                </div>
                <div class="card-body px-5">
                    <div class="form-row pt-3">
                        <div class="col-6 form-group">
                            <select class="form-control" id="staff" name="staff">
                                @foreach ($staffs as $value)
                                    <option value="{{$value->id}}" {{ (old('staff') == $value ? 'selected':'') }}>
                                        {{$value->general->name}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="staff" class="form-control-placeholder">Staff</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <select class="form-control" name="ict_type" id="ict-type">
                                @foreach ($ict_types as $type)
                                    <option value="{{$type->id}}" {{ (old('ict_type') == $type ? 'selected':'') }}>
                                        {{$type}}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-control-placeholder" for="ict-type">ICT Staff Job Title</label>
                        </div>
                         
                    </div>
                    <div class="form-row pt-3">
                        <div class="col form-group">
                            <textarea class="form-control" id="additional_remarks" name="additional_remark"
                                      rows="3">{{ old('additional_remark') }}</textarea>
                            <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection
