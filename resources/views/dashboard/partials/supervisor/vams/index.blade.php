<section class="py-4">
      <div class="container">
            <div class="row pb-4">
                  <div class="col-12">
                        <!-- Title -->
                        <div class="d-sm-flex justify-content-sm-between align-items-center">
                              <h1 class="mb-2 mb-sm-0 h3">درخواست های وام</h1>
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
                                                            <th scope="col" class="border-0">مبلغ ( تومان )</th>
                                                            <th scope="col" class="border-0">تاریخ درخواست</th>
                                                            <th scope="col" class="border-0">وضعیت</th>
                                                            <th scope="col" class="border-0">عملیات</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="border-top-0">

                                                      @forelse($vams as $vam)
                                                      <tr>
                                                            <td>{{ $vam->id }}</td>
                                                            <td>{{ $vam->user->name ?? '---' }}</td>
                                                            <td>{{$vam->idCard}}</td>
                                                            <td>{{$vam->price}}</td>
                                                            <td>
                                                                  <h6 class="course-title mb-0">{{ jdate($vam->created_at)->format('Y/m/d') }}</h6>
                                                            </td>

                                                            @if($vam->status === 'No')
                                                            <td>
                                                                  <h6 class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>عدم تایید</h6>
                                                            </td>
                                                            @elseif($vam->status==='Yes')
                                                            <td>
                                                                  <h6 class="badge text-bg-success mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>تایید</h6>
                                                            </td>
                                                            @else
                                                            <td>
                                                                  <h6 class="badge text-bg-warning mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>بررسی نشده</h6>
                                                            </td>

                                                            @endif
                                                            <td>
                                                                  <a href="{{ route('supervisor.vam.edit', $vam->id) }}" class="btn btn-sm btn-warning">
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