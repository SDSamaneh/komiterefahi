<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">
                                    درخواست خرید از مادیران
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{$maadiranCount}}</span>
                              </h1>
                              <a href="{{route('maadiran.create')}}" class="btn btn-sm btn-primary mb-0"><i class="fas fa-plus me-2"></i>ثبت درخواست خرید جدید</a>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6 col-xl-12">
          
                        <div class="card border bg-transparent rounded-3">

                              <div class="card-header bg-transparent border-bottom p-3">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                          <form action="{{ route('maadiran.index') }}" method="GET" class="mb-3">
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
                                                            <th scope="col" class="border-0  rounded-start">شناسه</th>
                                                            <th scope="col" class="border-0">نام و نام خانوادگی</th>
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
                                                      @if($maadirans)

                                                      @foreach($maadirans as $maadiran)

                                                      @php
                                                      $isFullyApproved = (
                                                      $maadiran->validationHr === 'Yes' &&
                                                      $maadiran->validation_managerHr === 'Yes'
                                                      );

                                                      @endphp

                                                      <tr>
                                                            <td @if($isFullyApproved) style="background-color: green;" @endif>

                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$maadiran->id}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$maadiran->name}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$maadiran->idCard}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$maadiran->price}}</h6>
                                                            </td>

                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">{{$maadiran->category}}</h6>
                                                            </td>
                                                            <td>
                                                                  <h6 class="course-title mt-2 mt-md-0 mb-0">
                                                                        {{ jdate($maadiran->created_at)->format('Y/m/d') }}
                                                                  </h6>
                                                            </td>
                                                            <td>
                                                                  <ul class="navbar-nav">
                                                                       
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $maadiran->status == 'Yes' ? 'green' :
                                                                              ($maadiran->status == 'No' ? 'red' : 'grey') }}"></i> مدیر واحد
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-clock" style="color: {{ $maadiran->validationHr == 'Yes' ? 'green' : 
                                                                              ($maadiran->validationHr == 'No' ? 'red' : 'orange')}}"></i> اعتبار سنجی
                                                                        </li>
                                                                        <li class="nav-item">
                                                                              <i class="fas fa-check-circle" style="color: {{ $maadiran->validation_managerHr == 'Yes' ? 'green' :
                                                                               ($maadiran->validation_managerHr == 'No' ? 'red' : 'grey') }}"></i> مدیر منابع انسانی
                                                                        </li>

                                                                  </ul>
                                                            </td>


                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','humanResources','managerHr','manager1','manager2']))

                                                            <td>
                                                                  <a href="{{ route('maadiran.edit', $maadiran->id) }}" class="text-success mb-0 me-2">
                                                                        <i class="fas fa-edit"></i>
                                                                  </a>
                                                            </td>

                                                            @else
                                                            <td></td>
                                                            @endif

                                                            @if(auth()->check() && auth()->user()->hasAnyRole(['admin','managerHr','humanResources']) )

                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <form action="{{ route('maadiran.destroy', $maadiran->id) }}" method="post">
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
                                                                  <h6 class="course-title mb-0">{{$maadiran->descriptionEdari}}</h6>
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
                                          {{ $maadirans->appends(request()->query())->links() }}
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>