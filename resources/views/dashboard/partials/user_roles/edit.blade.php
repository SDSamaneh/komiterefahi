<section class="py-4">
      <div class="container">
            <div class="row g-4">
                  <div class="col-12">
                        <div class="card border">
                              <div class="card-header mb-3 mt-3 d-sm-flex justify-content-sm-between align-items-center">
                                    <h1 class="mb-2 mb-sm-0"> ویرایش نقش کاربر :
                                          <span class="text-primary">{{ $user->name }}</span>
                                    </h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('admin.user_roles.update', $user->id) }}" method="POST">
                                          @csrf
                                          @method('PUT')

                                          <div class="row">
                                                @foreach($roles as $role)
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                      <div class="form-check border rounded p-2 shadow-sm h-100">
                                                            <input
                                                                  type="checkbox"
                                                                  class="form-check-input"
                                                                  id="role_{{ $role->id }}"
                                                                  name="roles[]"
                                                                  value="{{ $role->id }}"
                                                                  {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                            <label class="form-check-label ms-1 fw-semibold" for="role_{{ $role->id }}">
                                                                  {{ $role->name }}
                                                            </label>
                                                      </div>
                                                </div>
                                                @endforeach
                                          </div>

                                          <div class="col-md-12 d-flex gap-2 justify-content-end mt-5">
                                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> ذخیره نقش‌ها</button>
                                                <a href="{{route('admin.user_roles.index')}}" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> انصراف</a>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>