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
                  @if(auth()->check() && !in_array(auth()->user()->role, ['subscriber', 'author']))

                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-wallet"></i>
<<<<<<< HEAD
                                    مدیریت وام ها</a>
=======
<<<<<<< HEAD
                                    درخواست وام ها</a>
=======
                                    مدیریت وام ها</a>
>>>>>>> 81081fa35ab13447141f5de902fc110a4dd26b65
>>>>>>> 26b23e8 (final)
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <!-- dropdown submenu -->
                                    <li> <a class="dropdown-item" href="{{route('vam.index')}}">همه درخواست ها</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('vam.create')}}">افزودن درخواست وام</a> </li>
                              </ul>
                        </li>
                        <li class="nav-item dropdown">
<<<<<<< HEAD
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-tools"></i>
                                    مدیریت درخواست تعمیرگاه</a>
=======
<<<<<<< HEAD
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-store"></i>
                                    درخواست خرید از کویر</a>
=======
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-tools"></i>
                                    مدیریت درخواست تعمیرگاه</a>
>>>>>>> 81081fa35ab13447141f5de902fc110a4dd26b65
>>>>>>> 26b23e8 (final)
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <!-- dropdown submenu -->
                                    <li> <a class="dropdown-item" href="{{route('service.index')}}">همه درخواست ها</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('service.create')}}">افزودن درخواست</a> </li>
                              </ul>
                        </li>
<<<<<<< HEAD
			<li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-people me-1 fs-5"></i>مدیریت درخواست خرید مادیران</a>
=======
<<<<<<< HEAD
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-store"></i> درخواست خرید از مادیران</a>
=======
			<li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-people me-1 fs-5"></i>مدیریت درخواست خرید مادیران</a>
>>>>>>> 81081fa35ab13447141f5de902fc110a4dd26b65
>>>>>>> 26b23e8 (final)
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('maadiran.index')}}">همه درخواست ها</a></li>
                                    <li> <a class="dropdown-item" href="{{route('maadiran.create')}}">افزودن درخواست</a> </li>

                              </ul>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-people me-1 fs-5"></i>مدیریت کاربران</a>
                              <ul class="dropdown-menu" aria-labelledby="postMenu">
                                    <li> <a class="dropdown-item" href="{{route('users.index')}}">همه کاربران</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('supervisor.index')}}">مدیران واحد</a> </li>
                                    <li> <a class="dropdown-item" href="{{route('departman.index')}}">دپارتمان</a> </li>
                              </ul>
                        </li>
<<<<<<< HEAD

=======
<<<<<<< HEAD
=======

>>>>>>> 81081fa35ab13447141f5de902fc110a4dd26b65
>>>>>>> 26b23e8 (final)
                        <li class="nav-item">
                              <a class="nav-link" href="{{route('profile.edit')}}"><i class="far fa-user me-1"></i>پروفایل </a>
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
<<<<<<< HEAD
</nav>
=======
<<<<<<< HEAD
</nav>
=======
</nav>
>>>>>>> 81081fa35ab13447141f5de902fc110a4dd26b65
>>>>>>> 26b23e8 (final)
