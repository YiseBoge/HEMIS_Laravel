@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="error mx-auto" data-text="401">401</div>
        <p class="lead text-gray-800 mb-5">Unauthorized Request</p>
        <p class="text-gray-500">Sorry but you are not allowed here...</p>
        <a href="{{\Illuminate\Support\Facades\URL::previous()}}">← Go Back</a>
    </div>
@endsection
