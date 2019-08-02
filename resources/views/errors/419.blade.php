@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="error mx-auto" data-text="404">419</div>
        <p class="lead text-gray-800 mb-5">Page Expired</p>
        <p class="text-gray-500">Your page has expired</p>
        <a href="{{\Illuminate\Support\Facades\URL::previous()}}">← Go Back</a>
    </div>
@endsection
