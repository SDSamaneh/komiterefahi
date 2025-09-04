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
                  @if(auth()->check() && auth()->user()->hasAnyRole(['manager2','admin', 'manager1','humanResources','managerM','managerHr']))
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-wallet"></i>
                                    درخواست وام ها</a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('vam.index')}}">همه درخواست ها</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('vam.create')}}">افزودن درخواست وام</a> </li>
                              </ul>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-motorcycle"></i> درخواست از کویر</a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('service.index')}}">همه درخواست ها</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('service.create')}}">افزودن درخواست</a> </li>
                              </ul>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-store"></i> درخواست از مادیران</a>

                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('maadiran.index')}}">همه درخواست ها</a></li>
                                    <li> <a class="dropdown-item" href="{{route('maadiran.create')}}">افزودن درخواست</a> </li>

                              </ul>
                        </li>

                        @if(auth()->check() && auth()->user()->hasAnyRole(['managerM', 'admin','humanResources']))

                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درخواست مساعده</a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('imprest.index')}}">همه درخواست ها</a></li>
                                    <li> <a class=" dropdown-item" href="{{route('imprest.create')}}">افزودن درخواست</a> </li>

                              </ul>
                        </li>
                        @endif

                        @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources']))

                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-people me-1 fs-5"></i>مدیریت کاربران</a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('users.index')}}">همه کاربران</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('supervisor.index')}}">مدیران واحد</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('departman.index')}}">دپارتمان</a> </li>
                              </ul>
                        </li>
                        @endif

                        @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))

                        <li class="nav-item dropdown">
                              <a class="nav-link" href="{{route('admin.user_roles.index')}}">مدیریت نقش</a>

                        </li>
                        @endif
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('profile.edit')}}"><i class="far fa-user me-1"></i></a>
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