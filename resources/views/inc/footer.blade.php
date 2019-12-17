<!-- Footer -->
<footer class="sticky-footer bg-white shadow mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                <ul class="list-inline mb-2">
                    {{--                    <li class="list-inline-item">--}}
                    {{--                        <a href="#">About</a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="list-inline-item">&sdot;</li>--}}
                    <li class="list-inline-item">
                        <a href="{{ url('/comments/create') }}">Feedback</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <a href="{{ url('/manual') }}">Usage Manual</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <a href="{{ url('/support-contacts/public-view') }}">Contact Support</a>
                    </li>
                </ul>
                <p class="text-muted small mb-4 mb-lg-0">Copyright &copy; MoSHE - Ministry of Science and Higher
                    Education - Ethiopia - {{date("Y")}}</p>
            </div>
            <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                        <a href="https://www.facebook.com/SHE.Ethio/" target="_blank">
                            <i class="fab fa-facebook fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li class="list-inline-item mr-3">
                        <a href="https://twitter.com/she_ethiopia" target="_blank">
                            <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="mailto:moshe@ethernet.edu.et" target="_blank">
                            <i class="fas fa-envelope fa-2x fa-fw"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- End of Footer -->