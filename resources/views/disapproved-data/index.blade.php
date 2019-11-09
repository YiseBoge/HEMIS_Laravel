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
                        <p class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">{{$key}}</p>
                        <ul>
                        @foreach (array_unique($value) as $link)
                            <li class="text-danger my-3"><a class="text-danger" href="{{$link}}">{{$link}}</a></li>
                        @endforeach    
                        </ul>      
                    @endif              
                @endforeach
            </div>
            </div>
    </div>
</div>
@endsection