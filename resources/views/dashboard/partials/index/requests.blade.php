<div class="col-12">
      <div class="row g-4">

            <div class="card border bg-transparent rounded-3">
                  <!-- Card header START -->
                  <div class="card-header bg-transparent border-bottom p-3">
                        <div class="d-sm-flex justify-content-between align-items-center">
                              <h5 class="mb-2 mb-sm-0">آخرین اطلاعیه ها</h5>
                              <form action="{{ route('user_news.index') }}" method="GET" class="mb-3">
                                    <div class="input-group">
                                          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="براساس عنوان و ...">
                                          <button type="submit" class="btn btn-danger">جستجو</button>
                                    </div>
                              </form>
                        </div>
                  </div>
                  <!-- Card header END -->

                  <!-- Card body START -->
                  <div class="card-body p-3">
                        <div class="table-responsive border-0">
                              <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                    <!-- Table head -->
                                    <thead class="table-dark">
                                          <tr>
                                                <th scope="col" class="border-0 rounded-start">عنوان</th>
                                                <th scope="col" class="border-0">توضیحات</th>
                                                <th scope="col" class="border-0">تاریخ انتشار</th>
                                                <th scope="col" class="border-0">جزئیات</th>

                                          </tr>
                                    </thead>

                                    <!-- Table body START -->
                                    <tbody class="border-top-0">
                                          @if($news)

                                          @foreach($news as $item)
                                          <tr>
                                                <td>
                                                      <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$item->title}}</a></h6>
                                                </td>
                                                <td>
                                                      <h6 class="course-title mb-0">{{$item->shortDescription}}</h6>
                                                </td>
                                                <td>
                                                      <h6 class="course-title mb-0">{{ jdate($item->created_at)->format('Y/m/d') }}</h6>
                                                </td>
                                                <td>
                                                      <a href="{{ route('user_news.show', $item->id) }}" class="badge text-bg-primary mb-2">
                                                            <i class="far fa-eye"></i>
                                                      </a>
                                                </td>

                                          </tr>

                                          @endforeach
                                          @else
                                          <div class="alert alert-info">
                                                تا این لحظه دسته بندی ثبت نشده است !
                                          </div>
                                          @endif
                                    </tbody>
                                    <!-- Table body END -->
                              </table>
                        </div>
                        <!-- Blog list table END -->
                        <div class="d-flex justify-content-center mt-4">
                              {{ $news->appends(request()->query())->links() }}
                        </div>
                  </div>
            </div>

            @if(auth()->check() && auth()->user()->hasAnyRole(['managerHr', 'author','manager1','manager2']))

            <hr />
            <div class="text-center mt-4 mb-4">
                  <h4>کارتابل درخواست مدیران</h4>
            </div>
            <div class="col-sm-6 col-lg-3">
                  <div class="card card-body border p-3">
                        <a href="{{route('supervisor.vam.index')}}">
                              <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl fs-1 bg-primary bg-opacity-10 rounded-3">
                                          <img src="{{asset('storage/images/request-for-proposal.png')}}" alt="request" style="width: 50px;">
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                          <h6 class="mb-0">درخواست های وام</h6>
                                    </div>
                              </div>
                        </a>
                  </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                  <div class="card card-body border p-3">
                        <a href="{{route('supervisor.service.index')}}">
                              <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl fs-1 bg-primary bg-opacity-10 rounded-3">
                                          <img src="{{asset('storage/images/request-for-proposal.png')}}" alt="request" style="width: 50px;">
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                          <h6 class="mb-0">درخواست ها از کویر</h6>
                                    </div>
                              </div>
                        </a>
                  </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                  <div class="card card-body border p-3">
                        <a href="{{route('supervisor.maadiran.index')}}">
                              <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl fs-1 bg-primary bg-opacity-10 rounded-3">
                                          <img src="{{asset('storage/images/request-for-proposal.png')}}" alt="request" style="width: 50px;">
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                          <h6 class="mb-0">درخواست خرید از مادیران</h6>
                                    </div>
                              </div>
                        </a>
                  </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                  <div class="card card-body border p-3">
                        <a href="{{route('supervisor.imprest.index')}}">
                              <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl fs-1 bg-primary bg-opacity-10 rounded-3">
                                          <img src="{{asset('storage/images/request-for-proposal.png')}}" alt="request" style="width: 50px;">
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                          <h6 class="mb-0">درخواست مساعده</h6>
                                    </div>
                              </div>
                        </a>
                  </div>
            </div>
            @endif
      </div>
</div>