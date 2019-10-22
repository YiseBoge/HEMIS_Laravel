@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Today's Support Contacts</h6>
                </div>
                <div class="card-body text-center">
                    @forelse($contacts as $contact)
                        <div class="my-2">
                            {{$contact->name}} : {{$contact->phone}}
                        </div>
                    @empty
                        <div class="text-center">
                            <span class="text-danger">No Support contacts for Today</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


@endsection