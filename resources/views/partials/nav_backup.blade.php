<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <img src="{{ asset('assets/otw.png') }}" class="image" alt="">

        <div class="collapse navbar-collapse d-flex justify-content-center mx-2" id="navbarNav">
        <ul class="navbar-nav">
            <li class="fw-bold mx-5">
            <a class="nav-link" href="{{ route('admin.form') }}">Form</a>
            </li>
            <li class="fw-bold mx-5">
            <a class="nav-link" href="{{ route('status') }}">Status</a>
            </li>
            <li class="fw-bold mx-5">
            <a class="nav-link" href="{{ route('pembayaran') }}">Pembayaran</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
