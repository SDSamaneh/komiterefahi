<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">همه درخواست های خرید از کویر
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{$serviceCount}}</span>
                              </h1>
                              <a href="{{route('service.create')}}" class="btn btn-sm btn-primary mb-0"><i class="fas fa-plus me-2"></i>ثبت درخواست</a>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6 col-xl-12">
       
                        <div class="card border bg-transparent rounded-3">
                              <div class="card-header bg-transparent border-bottom p-3">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                          <form action="{{ route('service.index') }}" method="GET" class="mb-3">
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
                                                            <th scope="col" class="border-0 ">نام و نام خانوادگی</th>
                                                            <th scope="col" class="border-0">کدملی</th>
                                                            <th scope="col" class="border-0">مبلغ (تومان)</th>
                                                            <th scope="col" class="border-0">دسته بندی</th>
                                                            <th scope="col" class="border-0">تاریخ درخواست</th>
                                                            <th scope="col" class="border-0">وضعیت</th>
                                                            <th scope="col" class="border-0">عملیات</th>
                                                            <th scope="col" class="border-0">حذف</th>
                                                            <th scope="col" class="border-0">توضیحات</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">
                                                      @if($services)

                                                      @foreach($services as $service)

                                                      @php
                                                      $isFullyApproved = (
                                                      $service->validationHr === 'Yes' &&
                                                      $service->validation_managerHr === 'Yes' &&
                                                      $service->validationManager1 === 'Yes' &&
                                                      $service->validationManager2 === 'Yes'
                                                      );
                                                      @endphp

                                                      <tr>
                                                            <td @if($isFullyApproved) style="background-color: green;" @endif>

                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$service->id}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$service->number}}</a></h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$service->name}}</a></h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$service->idCard}}</a></h6>
                                                            </td>

                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0"><a href="#">{{$service->price}}</a></h6>
                                                            </td>

                                                            <td>
                                                                  <h6 class="course-title mb-0">{{$service->category}}</h6>
                                                            </td>

                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">
                                                                        {{ jdate($service->created_at)->format('Y/m/d') }}
                                                                  </h6>
                                                            </td>

                                                            <td>
                                                                  <ul class="navbar-nav">
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $service->status == 'Yes' ? 'green' :
                                                                              ($service->status == 'No' ? 'red' : 'grey') }}"></i> مدیر واحد
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-clock" style="color: {{ $service->validationHr == 'Yes' ? 'green' : 
                                                                              ($service->validationHr == 'No' ? 'red' : 'orange')}}"></i> اعتبار سنجی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $service->validation_managerHr == 'Yes' ? 'green' :
                                                                               ($service->validation_managerHr == 'No' ? 'red' : 'grey') }}"></i> مدیر منابع انسانی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $service->validationManager1 == 'Yes' ? 'green' :
                                                                                ($service->validationManager1 == 'No' ? 'red' : 'grey') }}"></i> مدیر مالی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $service->validationManager2 == 'Yes' ? 'green' : 
                                                                                    ($service->validationManager2 == 'No' ? 'red' : 'grey') }}"></i>رییس کمیته
                                                                        </li>
                                                                  </ul>
                                                            </td>


                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources','managerHr','manager1','manager2']))

                                                            <td>
                                                                  <a href="{{route('service.edit',$service->id)}}" class="text-success mb-0 me-2"><i class="fas fa-edit"></i></a>
                                                            </td>
                                                            @else
                                                            <td></td>
                                                            @endif

                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','managerHr','humanResources']) )

                                                            <td>
                                                                  <div class="d-flex justify-align-content-between align-items-center">
                                                                        <form action="{{ route('service.destroy', $service->id) }}" method="post">
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
                                                                  <h6 class="course-title mb-0">{{$service->descriptionEdari}}</h6>
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
                                          {{ $services->appends(request()->query())->links() }}
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>