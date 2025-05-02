{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container-fluid px-3 px-md-4"> <!-- Gunakan container-fluid dan responsive padding -->
        <!-- Brand/Logo -->
        <a class="navbar-brand py-1" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/otw.png') }}" alt="Logo" height="36" class="d-inline-block align-top">

        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-2 px-md-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1 d-lg-none"></i> <!-- Icon hanya muncul di mobile -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-2 px-md-3 {{ request()->routeIs('status') ? 'active' : '' }}"
                        href="{{ route('status') }}">
                        <i class="fas fa-info-circle me-1 d-lg-none"></i>
                        <span>Status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-2 px-md-3 {{ request()->routeIs('isi') ? 'active' : '' }}"
                        href="{{ route('isi') }}">
                        <i class="fas fa-tools me-1 d-lg-none"></i>
                        <span>Pesan</span>
                    </a>
                </li>
            </ul>

            <!-- User Dropdown -->
            @auth
            <div class="d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center py-2"
                        type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav> --}}


<nav class="navbar navbar-expand-lg navbar-glass fixed-top">
    <div class="container-fluid px-4">
        <!-- Animated Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <div class="logo-wrapper">
                <img src="{{ asset('assets/otw.png') }}" alt="Logo" class="logo-main">
                <img src="{{ asset('assets/otw.png') }}" alt="Logo" class="logo-dark">
            </div>
            <span class="brand-name">ServiceOtw</span>
        </a>

        <!-- Animated Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="toggler-bar toggler-bar-top"></span>
                <span class="toggler-bar toggler-bar-middle"></span>
                <span class="toggler-bar toggler-bar-bottom"></span>
            </span>
        </button>

        <!-- Main Navigation -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link magnetic-effect" href="{{ route('dashboard') }}" data-text="Dashboard">
                        <span class="nav-link-inner">
                            <i class="fas fa-home nav-icon"></i>
                            <span class="nav-text">Dashboard</span>
                            <span class="nav-underline"></span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link magnetic-effect" href="{{ route('status') }}" data-text="Status">
                        <span class="nav-link-inner">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <span class="nav-text">Status</span>
                            <span class="nav-underline"></span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link magnetic-effect" href="{{ route('isi') }}" data-text="Pesan">
                        <span class="nav-link-inner">
                            <i class="fas fa-tools nav-icon"></i>
                            <span class="nav-text">FormPemesanan</span>
                            <span class="nav-underline"></span>
                        </span>
                    </a>
                </li>
            </ul>

            <!-- User Profile with Microinteractions -->
            @auth
                <div class="user-profile">
                    <div class="dropdown">
                        <button class="user-avatar dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-wrapper">
                                {{-- <img src="#" alt="User Avatar" class="avatar-img"> --}}
                                <span class="status-indicator"></span>
                            </div>
                            <span class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Profil Saya</span>
                                    <div class="ripple-effect"></div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog"></i>
                                    <span>Pengaturan</span>
                                    <div class="ripple-effect"></div>
                                </a>
                            </li> --}}
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="#">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Keluar</span>
                                        <div class="ripple-effect"></div>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>



{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Magnetic Effect untuk Nav Links
        const magneticLinks = document.querySelectorAll('.magnetic-effect');

        magneticLinks.forEach(link => {
            link.addEventListener('mousemove', function (e) {
                const bounding = this.getBoundingClientRect();
                const x = e.clientX - bounding.left;
                const y = e.clientY - bounding.top;

                this.style.setProperty('--x', `${x}px`);
                this.style.setProperty('--y', `${y}px`);

                const intensity = 10;
                const text = this.querySelector('.nav-text');
                const icon = this.querySelector('.nav-icon');

                text.style.transform = `translate(${(x - bounding.width / 2) / intensity}px, ${(y - bounding.height / 2) / intensity}px)`;
                icon.style.transform = `translate(${(x - bounding.width / 2) / -intensity}px, ${(y - bounding.height / 2) / -intensity}px)`;
            });

            link.addEventListener('mouseleave', function () {
                const text = this.querySelector('.nav-text');
                const icon = this.querySelector('.nav-icon');

                text.style.transform = 'translate(0, 0)';
                icon.style.transform = 'translate(0, 0)';
            });
        });

        // Active Link Detection
        const navLinks = document.querySelectorAll('.nav-link');
        const currentPath = window.location.pathname;

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        // Smooth Mobile Menu Transition
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', function () {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                if (!isExpanded) {
                    navbarCollapse.style.display = 'block';
                    setTimeout(() => {
                        navbarCollapse.classList.add('show');
                    }, 10);
                }
            });
        }

        // Parallax Effect on Scroll
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-glass');
            const scrollY = window.scrollY;

            if (scrollY > 10) {
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.1)';
                navbar.style.background = 'rgba(255, 255, 255, 0.96)';
            } else {
                navbar.style.boxShadow = 'none';
                navbar.style.background = 'rgba(255, 255, 255, 0.86)';
            }
        });
    });
</script> --}}
