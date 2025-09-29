<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">همه اطلاعیه ها
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{$newsCount}}</span>
                              </h1>
                              <a href="{{route('news.create')}}" class="btn btn-sm btn-primary mb-0"><i class="fas fa-plus me-2"></i>ثبت اطلاعیه جدید</a>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6 col-xl-12">
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                              @if (session('success'))
                              <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                                    <div class="d-flex">
                                          <div class="toast-body">
                                                {{ session('success') }}
                                          </div>
                                          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                                    </div>
                              </div>
                              @endif

                              @if (session('error'))
                              <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                                    <div class="d-flex">
                                          <div class="toast-body">
                                                {{ session('error') }}
                                          </div>
                                          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                                    </div>
                              </div>
                              @endif
                        </div>
                        <div class="card border bg-transparent rounded-3">
                              <div class="card-header bg-transparent border-bottom p-3">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                          <form action="{{ route('news.index') }}" method="GET" class="mb-3">
                                                <div class="input-group">
                                                      <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="براساس عنوان و ...">
                                                      <button type="submit" class="btn btn-danger">جستجو</button>
                                                </div>
                                          </form>
                                    </div>
                              </div>
                              <div class="card-body p-3">
                                    <div class="table-responsive border-0">
                                          <table class="table align-middle p-1 mb-0 table-hover table-shrink">
                                                <thead class="table-dark">
                                                      <tr>
                                                            <th scope="col" class="border-0 rounded-start">شناسه</th>
                                                            <th scope="col" class="border-0">عنوان</th>
                                                            <th scope="col" class="border-0">توضیحات کوتاه</th>
                                                            <th scope="col" class="border-0">تاریخ</th>
                                                            <th scope="col" class="border-0">ویرایش</th>
                                                            <th scope="col" class="border-0">حذف</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">
                                                      @if($news)

                                                      @foreach($news as $item)

                                                      <tr>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$item->id}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$item->title}}</a></h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$item->shortDescription}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{ jdate($item->created_at)->format('Y/m/d') }}</h6>
                                                            </td>


                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources']))

                                                            <td>
                                                                  <a href="{{ route('news.edit', $item->id) }}" class="text-success mb-0 me-2">
                                                                        <i class="fas fa-edit"></i>
                                                                  </a>
                                                            </td>
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <form action="{{ route('news.destroy', $item->id) }}" method="post">
                                                                              @csrf
                                                                              @method('DELETE')
                                                                              <button type="submit" class="border-0 bg-transparent">
                                                                                    <i class="fas fa-trash text-danger"></i>
                                                                              </button>
                                                                        </form>
                                                                  </div>
                                                            </td>
                                                            @else
                                                            <td></td>
                                                            <td></td>
                                                            @endif

                                                      </tr>
                                                      @endforeach
                                                      @else
                                                      <div class="alert alert-info">
                                                            تا این لحظه دسته بندی ثبت نشده است !
                                                      </div>
                                                      @endif
                                                </tbody>
                                          </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                          {{ $news->appends(request()->query())->links() }}
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>