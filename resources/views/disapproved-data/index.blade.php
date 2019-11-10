@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Disapproved Data</h6>
            </div>
            <div class="card-body">
                @foreach ($links as $key => $value)
                    @if(!empty($value))
                        <div class="my-3">
                            <p class="font-weight-bold text-primary m-2">{{$key}}</p>
                            <ul class="list-group">
                                @foreach (array_unique($value) as $link)
                                    <li class="list-group-item"><a class="text-danger" href="{{$link}}">{{$link}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection