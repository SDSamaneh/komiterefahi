
      <section class="py-4">
            <div class="container">
                  <div class="row g-4">
                        <div class="col-12">
                              <div class="d-sm-flex justify-content-sm-between align-items-center">
                                    <h1>مدیریت نقش کاربران
                                          <span class="badge bg-primary bg-opacity-10 text-primary">{{$userCount}}</span>
                                    </h1>
                              </div>
                        </div>

                        <div class="col-md-6 col-xl-12">
                              <div class="card border bg-transparent rounded-3">
                                    <div class="card-header bg-transparent border-bottom p-3">
                                          <div class="d-sm-flex justify-content-between align-items-center">
                                                <form action="{{ route('admin.user_roles.index') }}" method="GET" class="mb-3">
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
                                                                  <th scope="col" class="border-0">کاربران</th>
                                                                  <th scope="col" class="border-0">کدملی</th>
                                                                  <th scope="col" class="border-0">نقش‌ها</th>
                                                                  <th scope="col" class="border-0">ویرایش</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody class="border-top-0">

                                                            @foreach($users as $user)
                                                            <tr>
                                                                  <td>
                                                                        <h6 class="course-title mb-0">
                                                                              {{ $user->name }}
                                                                        </h6>
                                                                  </td>
                                                                  <td>
                                                                        <h6 class="course-title mb-0">
                                                                              {{ $user->idCard }}
                                                                        </h6>
                                                                  </td>
                                                                  <td>
                                                                        <h6 class="course-title mb-0"> {{ $user->roles->pluck('name')->join(', ') }}</h6>
                                                                  </td>
                                                                  <td><a class="text-success mb-0 me-2"  href="{{ route('admin.user_roles.edit', $user->id) }}"><i class="fas fa-edit"></i></a></td>
                                                            </tr>
                                                            @endforeach
                                                      </tbody>
                                                </table>
                                          </div>
                                          <div class="d-flex justify-content-center mt-4">
                                                {{ $users->appends(request()->query())->links() }}
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </section>
