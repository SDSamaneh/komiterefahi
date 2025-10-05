<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">همه درخواست های وام
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{$vamCount}}</span>
                              </h1>
                              <a href="{{route('vam.create')}}" class="btn btn-sm btn-primary mb-0"><i class="fas fa-plus me-2"></i>ثبت درخواست وام جدید</a>
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
                                          <form action="{{ route('vam.index') }}" method="GET" class="mb-3">
                                                <div class="input-group">
                                                      <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="براساس نام و کدملی و ...">
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
                                                            <th scope="col" class="border-0">شماره درخواست</th>
                                                            <th scope="col" class="border-0">نام و نام خانوادگی</th>
                                                            <th scope="col" class="border-0">کدملی</th>
                                                            <th scope="col" class="border-0">مبلغ (تومان)</th>
                                                            <th scope="col" class="border-0">تاریخ درخواست</th>
                                                            <th scope="col" class="border-0">وضعیت</th>
                                                            <th scope="col" class="border-0">عملیات</th>
                                                            <th scope="col" class="border-0">حذف</th>
                                                            <th scope="col" class="border-0">توضیحات</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">
                                                      @if($vams)

                                                      @foreach($vams as $vam)

                                                      @php
                                                      $isFullyApproved = (

                                                      $vam->validationHr === 'Yes' &&
                                                      $vam->validation_managerHr === 'Yes' &&
                                                      $vam->validationManager1 === 'Yes' &&
                                                      $vam->validationManager2 === 'Yes'

                                                      );

                                                      @endphp

                                                      <tr>

                                                            <td @if($isFullyApproved) style="background-color: green;" @endif>

                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$vam->id}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$vam->number}}</a></h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$vam->name}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$vam->idCard}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$vam->price}}</h6>
                                                            </td>

                                                            <td>
                                                                  <h6 class="course-title mb-0">{{ jdate($vam->created_at)->format('Y/m/d') }}</h6>
                                                            </td>
                                                            <td>
                                                                  <ul class="navbar-nav">
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $vam->status == 'Yes' ? 'green' :
                                                                              ($vam->status == 'No' ? 'red' : 'grey') }}"></i> مدیر واحد
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-clock" style="color: {{ $vam->validationHr == 'Yes' ? 'green' : 
                                                                              ($vam->validationHr == 'No' ? 'red' : 'orange')}}"></i> اعتبار سنجی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $vam->validation_managerHr == 'Yes' ? 'green' :
                                                                               ($vam->validation_managerHr == 'No' ? 'red' : 'grey') }}"></i> مدیر منابع انسانی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $vam->validationManager1 == 'Yes' ? 'green' :
                                                                                ($vam->validationManager1 == 'No' ? 'red' : 'grey') }}"></i> مدیر مالی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $vam->validationManager2 == 'Yes' ? 'green' : 
                                                                                    ($vam->validationManager2 == 'No' ? 'red' : 'grey') }}"></i> رییس کمیته
                                                                        </li>
                                                                  </ul>
                                                            </td>


                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources','managerHr','manager1','manager2']))

                                                            <td>
                                                                  <a href="{{ route('vam.edit', $vam->id) }}" class="text-success mb-0 me-2">
                                                                        <i class="fas fa-edit"></i>
                                                                  </a>
                                                            </td>
                                                            @else
                                                            <td></td>
                                                            @endif

                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','managerHr','humanResources']) )
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <form action="{{ route('vam.destroy', $vam->id) }}" method="post">
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
                                                            @endif
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$vam->descriptionEdari}}</h6>
                                                            </td>
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
                                          {{ $vams->appends(request()->query())->links() }}
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>