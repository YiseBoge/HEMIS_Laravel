@if(count($errors) > 0)
    <div class="container-fluid p-0 px-md-3">
        <div class="alert alert-danger animated--fade-in">
            <h5 class="font-weight-bold">Please fix the following issues</h5>
            <hr class="mt-0">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


@if (session('success'))
    <div class="container-fluid p-0 px-md-3">
        <div class="card border-0 shadow-none">
            <div class="fade-alert alert alert-success text-center shadow w-100 animated--fade-in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <i class="far fa-check-circle fa-sm d-inline-block mx-2"></i>
                <strong>Hurray!!</strong> {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if (session('primary'))
    <div class="container-fluid p-0 px-md-3">
        <div class="card border-0 shadow-none">
            <div class="fade-alert alert alert-primary text-center shadow w-100 animated--fade-in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <i class="far fa-check-circle fa-sm d-inline-block mx-2"></i>
                {{ session('primary') }}
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="container-fluid p-0 px-md-3">
        <div class="card border-0 shadow-none">
            <div class="fade-alert alert alert-danger text-center shadow w-100 animated--fade-in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <i class="fas fa-times fa-sm d-inline-block mx-2"></i>
                <strong>Oops!!</strong> {{ session('error') }}
            </div>
        </div>
    </div>
@endif