<nav class="navbar navbar-expand-lg">
      <div class="container">
            <a class="navbar-brand me-3" href="{{route('index')}}">
                  <img class="navbar-brand-item light-mode-item" src="{{asset('storage/images/logo.png')}}" alt="logo">
            </a>
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
            </button>
            @endauth
            <!-- Main navbar START -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                  @if(auth()->check() && auth()->user()->hasAnyRole(['it']))
                  <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                              <a class="nav-link" href="{{route('it.user.index')}}">پنل فناوری اطلاعات <i class="fas fa-arrow-left"></i></a>
                        </li>
                  </ul>
                  @endif

                  @if(auth()->check() && auth()->user()->hasAnyRole(['admin','author']))
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    کارتابل مدیران
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('supervisor.vam.index')}}">درخواست های وام</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('supervisor.service.index')}}"> درخواست خرید از کویر</a></li>
                                    <li> <a class="dropdown-item" href="{{route('supervisor.maadiran.index')}}"> درخواست خرید از مادیران</a></li>
                              </ul>
                        </li>
                  </ul>
                  @endif

                  @if(auth()->check() && auth()->user()->hasAnyRole(['subscriber','admin','author','manager2', 'manager1','humanResources','managerM','managerHr']))

                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('vam.create')}}"><i class="fas fa-wallet"></i>ثبت درخواست وام</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('service.create')}}"><i class="fas fa-motorcycle"></i> درخواست خرید از کویر</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('maadiran.create')}}"><i class="fas fa-shopping-basket"></i> درخواست خرید از مادیران</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('imprest.create')}}"><i class="fas fa-money-check"></i> درخواست مساعده</a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('profile.edit')}}"><i class="far fa-user me-1"></i>پروفایل</a>
                        </li>

                  </ul>
                  @endif
            </div>
            <!-- Main navbar END -->
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