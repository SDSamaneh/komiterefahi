<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        @php

                        $user = auth()->user();

                        $canEditUserFields = $user && $user->hasAnyRole(['subscriber','humanResources','admin']);

                        $canEditManagerM = $user && $user->hasAnyRole(['managerM', 'admin']);

                        @endphp

                        <div class="d-sm-flex justify-content-end align-items-end">
                              <a href="{{route('index')}}" class="btn btn-sm text-danger mb-3">انصراف <i class="fas fa-chevron-left"></i></a>
                        </div>

                        <div class="card border">
                              <div class="card-header text-center mb-3 mt-3">
                                    <h1 class="mb-3">ویرایش درخواست مساعده</h1>
                              </div>
                              <div class="card-body">
                                    <div class="col-md-6">
                                          @if (session('success'))
                                          <div class="alert alert-success">
                                                {{ session('success') }}
                                          </div>
                                          @endif

                                          @if (session('error'))
                                          <div class="alert alert-danger">
                                                {{ session('error') }}
                                          </div>
                                          @endif
                                    </div>
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

                                                @if($imprest->status === 'Yes')
                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">تاییدیه مدیر منابع انسانی</h4>
                                                @if($canEditManagerM)
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="description" rows="3" {{ $canEditManagerM ? '' : 'readonly' }}>{{ old('description', $imprest->description) }}</textarea>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ نهایی (تومان)</label>
                                                      <input name="finalPrice" type="text" class="form-control"
                                                            value="{{ old('finalPrice', $imprest->finalPrice ?? $imprest->price) }}"
                                                            {{ $canEditManagerM ? '' : 'readonly' }}>
                                                      @error('finalPrice')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
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
                                                <div class="d-flex justify-content mt-3">
                                                      <a class="btn btn-danger" href="{{route('imprest.index')}}"> بازگشت</a>
                                                </div>
                                                @else
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ نهایی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $imprest->finalPrice }}</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $imprest->description }}</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">نتیجه نهایی </label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $imprest->accept === 'Yes' ? 'تأیید شده' : ($imprest->accept === 'No' ? 'عدم تأیید' : ($imprest->accept === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif

                                          </div>
                                          @endif
                                          <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">ذخیره تغییرات</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>