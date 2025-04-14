<nav class="navbar navbar-expand-lg ps-4 fixed-top" style="background-color: rgb(226, 226, 226)">
    <div class="container-fluid d-flex justify-content-center">

        <!-- Logo -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/otw.png') }}" class="image" alt="">
        </div>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="fw-bold mx-5">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="fw-bold mx-5">
                    <a class="nav-link" href="{{ route('isi') }}">Pesan</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
