<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        @php
                       
                        $user = auth()->user();

                        // مجوزهای دسترسی
                        $canEditUserFields = $user && in_array($user->role, ['subscriber', 'admin']) && $imprest->accept !== 'Yes';
                        $canEditManagerM = $user && $user->role === 'managerM';

                        @endphp

                        <div class="card border">
                              <div class="card-header text-center mb-3 mt-3">
                                    <h1 class="mb-3">ویرایش درخواست مساعده</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('imprest.update', $imprest->id) }}" method="post">
                                          @csrf
                                          @method('PUT')
                                          <div class="row">
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">نام و نام خانوادگی</label>
                                                      <input name="name" type="text" class="form-control" value="{{ old('name', $imprest->name) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">کدملی</label>
                                                      <input name="idCard" type="text" class="form-control" value="{{ old('idCard', $imprest->idCard) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('idCard') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ درخواستی (تومان)</label>
                                                      <input name="price" type="text" class="form-control" id="priceInput" value="{{ old('price', $imprest->price) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">محل خدمت ( تابع )</label>
                                                            @if($canEditUserFields)
                                                            <select class="form-select" name="loc" aria-label="Default select example" required>
                                                                  <option value="" disabled>انتخاب کنید</option>
                                                                  @foreach(['یکتاز','اوراسیا'] as $loc)
                                                                  <option value="{{ $loc }}" {{ old('loc', $imprest->loc) == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                                                  @endforeach
                                                            </select>
                                                            @else
                                                            <select class="form-select" disabled>
                                                                  <option selected>{{ $imprest->loc }}</option>
                                                            </select>
                                                            @endif

                                                            @error('loc')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                          </div>

                                          @if($imprest->status === 'Yes')
                                          <hr />
                                          <h4 class="text-center mt-4 mb-4">تاییدیه مدیر منابع انسانی</h4>
                                          @if($canEditManagerM)
                                          <div class="col-md-4 mt-4 d-flex gap-4">
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="accept" value="Pending"
                                                            {{ old('accept', $imprest->accept) == 'Pending' ? 'checked' : '' }}>
                                                      <label class="form-check-label">در حال بررسی</label>
                                                </div>
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="accept" value="Yes"
                                                            {{ old('accept', $imprest->accept) == 'Yes' ? 'checked' : '' }}>
                                                      <label class="form-check-label">تأیید</label>
                                                </div>
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="accept" value="No"
                                                            {{ old('accept', $imprest->accept) == 'No' ? 'checked' : '' }}>
                                                      <label class="form-check-label">عدم تأیید</label>
                                                </div>
                                          </div>
                                          @else
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <label class="form-label">نتیجه بررسی مدیر منابع انسانی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $imprest->accept === 'Yes' ? 'تأیید شده' : ($imprest->accept === 'No' ? 'عدم تأیید' : ($imprest->accept === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                          </div>
                                          @endif

                                          @endif

                                          <div class="col-md-12 d-flex gap-2 justify-content-end mt-5">
                                                <button class="btn btn-primary" type="submit">ذخیره تغییرات</button>
                                                <a class="btn btn-danger" href="{{route('index')}}"> بازگشت</a>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>