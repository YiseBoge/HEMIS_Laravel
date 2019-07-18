@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif


@if (session('success'))
    <div class="card border-0 shadow-none">
        <div class="fade-alert alert alert-success text-center shadow w-100">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
            </button>
            <i class="far fa-check-circle fa-sm d-inline-block mx-2"></i>
            <strong>Hurray!!</strong> {{ session('success') }}
        </div>
    </div>
@endif

@if (session('primary'))
    <div class="card border-0 shadow-none">
        <div class="fade-alert alert alert-primary text-center shadow w-100">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
            </button>
            <i class="far fa-check-circle fa-sm d-inline-block mx-2"></i>
            {{ session('primary') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div class="card border-0 shadow-none">
        <div class="fade-alert alert alert-danger text-center shadow w-100">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
            </button>
            <i class="fas fa-times fa-sm d-inline-block mx-2"></i>
            <strong>Oops!!</strong> {{ session('error') }}
        </div>
    </div>
@endif