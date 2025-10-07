<nav class="navbar navbar-expand-lg">
      <div class="container">
            <a class="navbar-brand me-3" href="{{route('view')}}">
                  <img class="navbar-brand-item light-mode-item" src="{{asset('storage/images/logo.png')}}" alt="logo">
            </a>
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
            </button>
            @endauth
            <!-- Main navbar START -->
            <div class="collapse navbar-collapse  z-3" id="navbarCollapse">
                  @if(auth()->check() && auth()->user()->hasAnyRole(['it','admin']))
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                              <a class="nav-link" href="{{route('index')}}">سامانه خدمات رفاهی</a>
                        </li>
                  </ul>
                  @endif
            </div>

            <div class="navbar-nav gap-1">
                  @auth
                  <form method="post" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="bg-danger border-0 text-white"><i class="fas fa-sign-out-alt"></i> خروج</button>
                  </form>
                  @endauth
                  @guest
                  <a href="{{route('login')}}" class="btn btn-success btn-sm">ورود</a>
                  <a href="{{route('register')}}" class="btn btn-outline-primary btn-sm">ثبت نام</a>
                  @endguest
            </div>
      </div>
</nav>