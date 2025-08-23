<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">درخواست برای مساعده</h1>
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
                                                            <th scope="col" class="border-0 rounded-start">شناسه</th>
                                                            <th scope="col" class="border-0">نام و نام خانوادگی</th>
                                                            <th scope="col" class="border-0">کدملی</th>
                                                            <th scope="col" class="border-0">تاریخ درخواست</th>
                                                            <th scope="col" class="border-0">وضعیت</th>
                                                            <th scope="col" class="border-0">عملیات</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">

                                                      @forelse($imprest as $item)
                                                      <tr>
                                                            <td>{{$item->id}}</td>
                                                            <td>{{$item->user->name ?? '---' }}</td>
                                                            <td>{{$item->idCard}}</td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{ jdate($item->created_at)->format('Y/m/d') }}</h6>
                                                            </td>

                                                            @if($item->status === 'Pending')
                                                            <td>
                                                                  <h6 class="badge bg-warning mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>بررسی نشده</h6>
                                                            </td>
                                                            @elseif($item->status === 'No')
                                                            <td>
                                                                  <h6 class="badge bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>عدم اعتبار سنجی</h6>
                                                            </td>
                                                            @elseif($item->status === 'Yes')
                                                            <td>
                                                                  <h6 class="badge bg-success mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>اعتبارسنجی شده</h6>
                                                            </td>
                                                            @endif

                                                            <td>
                                                                  <a href="{{ route('supervisor.imprest.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                        ویرایش
                                                                  </a>
                                                            </td>
                                                      </tr>
                                                      @empty
                                                      <tr>
                                                            <td colspan="4">درخواستی یافت نشد</td>
                                                      </tr>
                                                      @endforelse
                                                </tbody>
                                          </table>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>