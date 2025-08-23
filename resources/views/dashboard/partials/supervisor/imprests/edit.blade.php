<section class="py-4">
      <div class="container">
            <h1>ویرایش درخواست مساعده</h1>

            <form action="{{ route('supervisor.imprest.update', $imprest->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="row">
                        <div class="col-md-4 mb-3">
                              <label class="form-label">نام کاربر</label>
                              <input class="form-control" type="text" value="{{ $imprest->user->name }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                              <label class="form-label">کد ملی</label>
                              <input class="form-control" type="text" value="{{ $imprest->user->idCard }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                              <label>مبلغ وام ( تومان )</label>
                              <input class="form-control" type="text" name="price" value="{{ old('price', $imprest->price) }}" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                              <label class="form-label">محل خدمت ( تابع )</label>

                              <select class="form-select" name="loc" aria-label="Default select example" required>
                                    @foreach(['اوراسیا', 'یکتاز'] as $loc)
                                    <option value="{{ $loc }}" {{ old('loc', $imprest->loc) == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                              </select>
                        </div>

                        <div class="col-md-4 mt-4 d-flex gap-4">
                              <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Pending"
                                          {{ old('status', $imprest->status) == 'Pending' ? 'checked' : '' }}>
                                    <label class="form-check-label">در حال بررسی</label>
                              </div>
                              <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="Yes"
                                          {{ old('status', $imprest->status) == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label">تأیید</label>
                              </div>
                              <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="No"
                                          {{ old('status', $imprest->status) == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label">عدم تأیید</label>
                              </div>
                        </div>


                        <div class="col-md-12 mt-5">

                              <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                              <a href="{{ route('supervisor.imprest.index') }}" class="btn btn-secondary">بازگشت</a>
                        </div>
                  </div>
            </form>
      </div>
</section>