<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">درخواست خرید از کویر </h1>
                              <a href="{{route('index')}}" class="btn btn-sm btn-danger mb-0">
                                    بازگشت
                                    <i class="fas fa-angle-left"></i>
                              </a>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6 col-xl-12">

                        <div class="card border bg-transparent rounded-3">
                              <div class="card-header bg-transparent border-bottom p-3">

                              </div>
                              <div class="card-body p-3">
                                    <div class="table-responsive border-0">
                                          <table class="table align-middle p-1 mb-0 table-hover table-shrink">
                                                <thead class="table-dark">
                                                      <tr>
                                                            <th scope="col" class="border-0  rounded-start">شناسه</th>
                                                            <th scope="col" class="border-0">نام و نام خانوادگی</th>
                                                            <th scope="col" class="border-0">کدملی</th>
                                                            <th scope="col" class="border-0">مبلغ ( تومان )</th>
                                                            <th scope="col" class="border-0">دسته بندی</th>
                                                            <th scope="col" class="border-0">تاریخ درخواست</th>
                                                            <th scope="col" class="border-0">وضعیت</th>
                                                            <th scope="col" class="border-0">عملیات</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">
                                                      @if($services)
                                                      @foreach($services as $service)
                                                      <tr>
                                                            <td>{{ $service->id }}</td>
                                                            <td>{{$service->name}}</td>
                                                            <td>{{$service->idCard}}</td>
                                                            <td>{{$service->price}}</td>
                                                            <td>{{$service->category}}</td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{ jdate($service->created_at)->format('Y/m/d') }}</h6>
                                                            </td>

                                                            @if($service->status === 'Pending')
                                                            <td>
                                                                  <h6 class="badge bg-warning mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>بررسی نشده</h6>
                                                            </td>
                                                            @elseif($service->status === 'No')
                                                            <td>
                                                                  <h6 class="badge bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>عدم اعتبار سنجی</h6>
                                                            </td>
                                                            @elseif($service->status === 'Yes')
                                                            <td>
                                                                  <h6 class="badge bg-success mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>اعتبارسنجی شده</h6>
                                                            </td>
                                                            @endif

                                                            <td>
                                                                  <a href="{{ route('supervisor.service.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                        ویرایش
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
                                          </table>
                                    </div>

                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>