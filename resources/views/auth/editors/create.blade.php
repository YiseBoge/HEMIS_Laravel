@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow jumbotron pt-4">
                    <h3>Add Editor</h3>
                    <hr>
                    <div class="card-body">
                        {!! Form::open(['action' => 'EditorsController@store', 'method' => 'POST']) !!}
                       
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Institution') }}</label>
                                <div class="col-md-8">
                                    {!! Form::select('institution_name_id', $data['institution_names'] ,null  , ['class' => 'form-control']) !!}
                                </div>
    
                            </div>
                            <div class="form-group col-md-6 row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('College') }}</label>
                                <div class="col-md-8">
                                    {!! Form::select('college_name_id', $data['college_names'] ,null  , ['class' => 'form-control']) !!}
                                </div>
    
                            </div>
                                                    
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Band') }}</label>
                                <div class="col-md-8">
                                    {!! Form::select('band_name_id', $data['band_names'] ,null  , ['class' => 'form-control']) !!}
                                </div>
    
                            </div>
                            <div class="form-group col-md-6 row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>
                                <div class="col-md-8">
                                    {!! Form::select('department_name_id', $data['department_names'] ,null  , ['class' => 'form-control']) !!}
                                </div>
    
                            </div>   
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-5">
                                {!! Form::submit('Add Editor', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
