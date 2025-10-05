@if(auth()->check() && auth()->user()->hasAnyRole(['manager2','admin', 'manager1','humanResources','managerM','managerHr']))

<!-- دکمه همبرگری فقط در موبایل -->
<button class="btn btn-primary m-3 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i> منو
</button>

<!-- سایدبار دسکتاپ -->
<nav class="d-none d-lg-block bg-black p-3 z-3" style="width: 240px; position: fixed; top: 0; right: 0; height: 100vh; overflow-y: auto;">
      <h5 class="mb-4">خدمات رفاهی</h5>
      <ul class="nav flex-column sidebar-nav">
            <div class="sidebar-header">
                  <div class="sidebar-brand">
                        <a href="{{route('index')}}">خدمات رفاهی</a>
                  </div>
            </div>
            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        درخواست وام ها</a>
                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('vam.index')}}">همه درخواست ها</a> </li>
                        <li> <a class="dropdown-item" href="{{route('vam.create')}}">افزودن درخواست وام</a> </li>
                  </ul>
            </li>
            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درخواست از کویر</a>
                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('service.index')}}">همه درخواست ها</a> </li>
                        <li> <a class="dropdown-item" href="{{route('service.create')}}">افزودن درخواست</a> </li>
                  </ul>
            </li>
            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درخواست از مادیران</a>

                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('maadiran.index')}}">همه درخواست ها</a></li>
                        <li> <a class="dropdown-item" href="{{route('maadiran.create')}}">افزودن درخواست</a> </li>

                  </ul>
            </li>
            @if(auth()->check() && auth()->user()->hasAnyRole(['managerM', 'admin','humanResources']))

            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درخواست مساعده</a>
                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('imprest.index')}}">همه درخواست ها</a></li>
                        <li> <a class=" dropdown-item" href="{{route('imprest.create')}}">افزودن درخواست</a> </li>

                  </ul>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources']))

            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">مدیریت کاربران</a>
                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('users.index')}}">همه کاربران</a> </li>
                        <li> <a class="dropdown-item" href="{{route('supervisor.index')}}">مدیران واحد</a> </li>
                        <li> <a class="dropdown-item" href="{{route('departman.index')}}">دپارتمان</a> </li>

                  </ul>
            </li>
            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">اطلاعیه</a>
                  <ul class="dropdown-menu" aria-labelledby="postMenu">
                        <li> <a class="dropdown-item" href="{{route('news.index')}}"> اطلاعیه ها</a></li>
                        <li> <a class=" dropdown-item" href="{{route('news.create')}}">اطلاعیه جدید</a> </li>

                  </ul>
            </li>

            @endif
            @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
            <li class="nav-item pb-3 dropdown">
                  <a class="nav-link" href="{{route('admin.user_roles.index')}}"> نقش پرسنل</a>
            </li>
            @endif
           
      </ul>
</nav>

<!-- سایدبار موبایل (offcanvas) -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarMenu">
      <div class="offcanvas-header">
            <h5 class="offcanvas-title">خدمات رفاهی</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
      </div>
      <div class="offcanvas-body">
            <ul class="nav flex-column">
                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-wallet"></i>
                              درخواست وام ها</a>
                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('vam.index')}}">همه درخواست ها</a> </li>
                              <li> <a class="dropdown-item" href="{{route('vam.create')}}">افزودن درخواست وام</a> </li>
                        </ul>
                  </li>
                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-motorcycle"></i> درخواست از کویر</a>
                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('service.index')}}">همه درخواست ها</a> </li>
                              <li> <a class="dropdown-item" href="{{route('service.create')}}">افزودن درخواست</a> </li>
                        </ul>
                  </li>
                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-store"></i> درخواست از مادیران</a>

                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('maadiran.index')}}">همه درخواست ها</a></li>
                              <li> <a class="dropdown-item" href="{{route('maadiran.create')}}">افزودن درخواست</a> </li>

                        </ul>
                  </li>
                  @if(auth()->check() && auth()->user()->hasAnyRole(['managerM', 'admin','humanResources']))

                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">درخواست مساعده</a>
                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('imprest.index')}}">همه درخواست ها</a></li>
                              <li> <a class=" dropdown-item" href="{{route('imprest.create')}}">افزودن درخواست</a> </li>

                        </ul>
                  </li>
                  @endif

                  @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources']))

                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">مدیریت کاربران</a>
                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('users.index')}}">همه کاربران</a> </li>
                              <li> <a class="dropdown-item" href="{{route('supervisor.index')}}">مدیران واحد</a> </li>
                              <li> <a class="dropdown-item" href="{{route('departman.index')}}">دپارتمان</a> </li>

                        </ul>
                  </li>
                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="postMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">اطلاعیه</a>
                        <ul class="dropdown-menu" aria-labelledby="postMenu">
                              <li> <a class="dropdown-item" href="{{route('news.index')}}"> اطلاعیه ها</a></li>
                              <li> <a class=" dropdown-item" href="{{route('news.create')}}">اطلاعیه جدید</a> </li>

                        </ul>
                  </li>

                  @endif
                  @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
                  <li class="nav-item pb-3 dropdown">
                        <a class="nav-link" href="{{route('admin.user_roles.index')}}"> نقش پرسنل</a>
                  </li>
                  @endif
                  <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.edit')}}"><i class="far fa-user me-1"></i>پروفایل</a>
                  </li>
            </ul>
      </div>
</div>
@endif