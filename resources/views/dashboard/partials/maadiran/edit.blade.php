<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
<<<<<<< HEAD
=======

                        @php
                        $steps = [
                        ['key' => 'accept', 'label' => 'ثبت درخواست'],
                        ['key' => 'status', 'label' => 'تأیید مدیر واحد'],
                        ['key' => 'validationHr', 'label' => 'اعتبارسنجی'],
                        ['key' => 'validationManager1', 'label' => 'تأیید مدیر مالی'],
                        ['key' => 'validationManager2', 'label' => 'تأیید نهایی'],
                        ];

                        // پیدا کردن مرحله فعلی
                        $currentStep = 1;
                        foreach ($steps as $index => $step) {
                        if (!empty($maadiran->{$step['key']}) && $maadiran->{$step['key']} === 'Yes') {
                        $currentStep = $index + 1;
                        } else {
                        break;
                        }
                        }
                        @endphp

                        <div class="col-md-12 border p-3 rounded-3 mb-3">
                              @php
                              $fillWidth = ($currentStep - 1) / (count($steps) - 1) * 100;
                              @endphp

                              <ul class="step-progress">
                                    @foreach ($steps as $index => $step)
                                    @php
                                    $statusClass = '';
                                    if ($index + 1 < $currentStep) {
                                          $statusClass='completed' ;
                                          } elseif ($index + 1==$currentStep) {
                                          $statusClass='active' ;
                                          }
                                          @endphp
                                          <li class="{{ $statusClass }}" data-step="{{ $index + 1 }}">
                                          {{ $step['label'] }}
                                          </li>
                                          @endforeach
                              </ul>
                        </div>
>>>>>>> 26b23e8 (final)
                        <div class="card border">
                              <div class="card-header text-center mb-3 mt-3">
                                    <h1 class="mb-3">ویرایش درخواست خرید مادیران</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('maadiran.update', $maadiran->id) }}" method="post">
                                          @csrf
                                          @method('PUT')
                                          <div class="row">
                                                @php
                                                $readonly = !(auth()->check() && in_array(auth()->user()->role, ['subscriber', 'author']) && $maadiran->status === 'No');
                                                @endphp
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">نام و نام خانوادگی</label>
                                                      <input name="name" type="text" class="form-control" value="{{ old('name', $maadiran->name) }}" {{ $readonly ? 'readonly' : '' }}>
                                                      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">کدملی</label>
                                                      <input name="idCard" type="text" class="form-control" value="{{ old('idCard', $maadiran->idCard) }}" {{ $readonly ? 'readonly' : '' }}>
                                                      @error('idCard') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ درخواستی (تومان)</label>
                                                      <input name="price" type="text" class="form-control" value="{{ old('price', $maadiran->price) }}" {{ $readonly ? 'readonly' : '' }}>
                                                      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">دپارتمان</label>
                                                      <select class="form-select" name="departmans_id" aria-label="Default select example">
                                                            <option value="" disabled selected>{{$maadiran->departmans->name}}</option>

                                                            @foreach($departmans as $departman)
                                                            <option value="{{$departman->id}}" {{ old('departmans_id', $maadiran->departmans_id) == $departman->id ? 'selected' : '' }}>
                                                                  {{$departman->name}}
                                                            </option>
                                                            @endforeach

                                                      </select>
                                                      @error('departmans_id')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">سرپرست واحد</label>
                                                      <select class="form-select" name="supervisors_id" aria-label="Default select example">
                                                            <option value="" disabled selected>{{$maadiran->supervisor->name}}</option>

                                                            @foreach($supervisors as $supervisor)
                                                            <option value="{{$supervisor->id}}" {{ old('supervisors_id', $maadiran->supervisors_id) == $supervisor->id ? 'selected' : '' }}>
                                                                  {{$supervisor->name}}
                                                            </option>
                                                            @endforeach

                                                      </select>
                                                      @error('supervisors_id')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">دسته بندی</label>
                                                            <select class="form-select" name="category" aria-label="Default select example" required>
                                                                  <option value="" disabled {{ old('category', $maadiran->category) ? '' : 'selected' }}>دلیل درخواست وام را انتخاب کنید</option>
                                                                  @foreach(['لوازم خانگی', 'موبایل', 'لپتاپ', 'تلویزیون', 'سایر'] as $category)
                                                                  <option value="{{ $category }}" {{ old('category', $maadiran->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                                                  @endforeach
                                                            </select>
                                                            @error('category')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label class="form-label">توضیحات</label>
                                                            <textarea class="form-control" name="descriptionUser" rows="3">{{ old('descriptionUser', $maadiran->descriptionUser) }}</textarea>
                                                            @error('descriptionUser')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-12 mt-5">
                                                      <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" name="accept" value="Yes" id="accept" checked>
                                                            <label class="form-check-label" for="accept">
                                                                  اینجانب متقاضی استفاده از امکانات رفاهی شرکت متعهد میشوم مطابق آئین نامه کمیته رفاهی و دستور العمل های پیوست آن از این امکانات استفاده نمایم و نسبت به تسویه حساب بدهی خود قبل از ترک کار اقدام نمایم. در صورت تخلف،شرکت و کمیته رفاهی میتواند علیه اینجانب اقدام قانونی نماید.
                                                            </label>
                                                            @error('accept')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                          </div>
<<<<<<< HEAD

                                          @if($maadiran->status === 'No')
                                          <div class="alert alert-warning text-center mt-4">
                                                درخواست هنوز توسط مدیر واحد تأیید نشده است.
                                          </div>
                                          @endif

                                          @if($maadiran->validationHr === 'No')
                                          <div class="alert alert-warning text-center mt-2">
                                                درخواست هنوز توسط منابع انسانی اعتبارسنجی نشده است.
                                          </div>
                                          @endif

=======
>>>>>>> 26b23e8 (final)
                                          @php
                                          $isHR = auth()->check() && auth()->user()->role === 'humanResources';
                                          @endphp

                                          @if($maadiran->status === 'Yes' && !empty($maadiran->validationHr) || $isHR)
                                          <hr />
                                          <div class="text-center mt-4 mb-4">
                                                <h4>فرم اعتبارسنجی منابع انسانی</h4>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                                      <label class="form-label">تاریخ عضویت در صندوق</label>
                                                      <input name="memberDate" type="text" class="form-control"
                                                            value="{{ old('memberDate', $maadiran->memberDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $isHR ? '' : 'readonly' }}>
=======
                                                      <label class="form-label">تاریخ ورود به سازمان</label>
                                                      <input name="memberDate" type="text" class="form-control input-field persian-date"
                                                            value="{{ old('memberDate', $maadiran->memberDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $isHR ? '' : 'readonly' }}>
                                                      <i class="fas fa-calendar-minus icon"></i>
>>>>>>> 26b23e8 (final)
                                                      @error('memberDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                                      <label class="form-label">مبلغ سرمایه گذاری در صندوق</label>
=======
                                                      <label class="form-label">مبلغ سرمایه گذاری در صندوق(تومان)</label>
>>>>>>> 26b23e8 (final)
                                                      <input name="memberPrice" type="text" class="form-control"
                                                            value="{{ old('memberPrice', $maadiran->memberPrice) }}"
                                                            {{ $isHR ? '' : 'readonly' }}>
                                                      @error('memberPrice')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
<<<<<<< HEAD
                                                      <label class="form-label">آخرین حقوق دریافتی</label>
=======
                                                      <label class="form-label">آخرین حقوق دریافتی(تومان)</label>
>>>>>>> 26b23e8 (final)
                                                      <input name="lastSalary" type="text" class="form-control"
                                                            value="{{ old('lastSalary', $maadiran->lastSalary) }}"
                                                            {{ $isHR ? '' : 'readonly' }}>
                                                      @error('lastSalary')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">میزان بدهی در زمان بهره برداری از امکانات رفاهی</label>
<<<<<<< HEAD
                                                      <input name="debt" type="text" class="form-control"
                                                            value="{{ old('debt', $maadiran->debt) }}"
                                                            {{ $isHR ? '' : 'readonly' }}>
=======
                                                      <textarea class="form-control" name="debt" rows="3">{{ old('debt', $maadiran->debt) }}</textarea>
>>>>>>> 26b23e8 (final)
                                                      @error('debt')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">تاریخ اعتبار سنجی</label>
<<<<<<< HEAD
                                                      <input name="validationDate" type="text" class="form-control"
                                                            value="{{ old('validationDate', $maadiran->validationDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $isHR ? '' : 'readonly' }}>
=======
                                                      <input name="validationDate" type="text" class="form-control persian-date"
                                                            value="{{ old('validationDate', $maadiran->validationDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $isHR ? '' : 'readonly' }}>
                                                      <i class="fas fa-calendar-minus icon"></i>

>>>>>>> 26b23e8 (final)
                                                      @error('validationDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
<<<<<<< HEAD
                                                @if($isHR)
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
=======
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">توضیحات</label>
                                                      <textarea class="form-control" name="descriptionHr" rows="3">{{ old('descriptionHr') }}</textarea>
                                                      @error('descriptionHr')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                @if($isHR)
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Pending"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
>>>>>>> 26b23e8 (final)
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Yes"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="No"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
<<<<<<< HEAD
                                                <div class="col-md-4 mt-4">
                                                      <label class="form-label">نتیجه اعتبارسنجی منابع انسانی</label>
                                                      <input type="text" class="form-control" value="{{ $maadiran->validationHr === 'Yes' ? 'تأیید شده' : ($maadiran->validationHr === 'No' ? 'عدم تأیید' : '---') }}" readonly>
=======
                                                <div class="col-md-12">
                                                      <label class="form-label">نتیجه اعتبارسنجی منابع انسانی</label>
                                                      <h6 class="badge bg-body-secondary text-black mb-3" readonly>{{ $maadiran->validationHr === 'Yes' ? 'تأیید شده' : ($maadiran->validationHr === 'No' ? 'عدم تأیید' : ($maadiran->validationHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>

>>>>>>> 26b23e8 (final)
                                                </div>
                                                @endif
                                          </div>
                                          @endif
<<<<<<< HEAD

                                          @php
                                          $isManager1 = auth()->check() && auth()->user()->role === 'manager1';
                                          @endphp

=======
                                          @php
                                          $isManager1 = auth()->check() && auth()->user()->role === 'manager1';
                                          @endphp
>>>>>>> 26b23e8 (final)
                                          @if($maadiran->validationHr === 'Yes')
                                          <hr />
                                          <div class="text-center mt-4 mb-4">
                                                <h4>تاییدیه توسط مدیر مالی</h4>
                                          </div>
                                          <div class="row">
<<<<<<< HEAD
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">مبلغ نهایی (تومان)</label>
                                                      <input name="finalPrice" type="text" class="form-control"
                                                            value="{{ old('finalPrice', $maadiran->finalPrice ?? $maadiran->price) }}"
                                                            {{ $isManager1 ? '' : 'readonly' }}>
                                                      @error('finalPrice')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="description" rows="3" {{ $isManager1 ? '' : 'readonly' }}>{{ old('description', $maadiran->description) }}</textarea>
                                                      @error('description')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>

                                                @if($isManager1)
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Yes" {{ old('validationManager1', $maadiran->validationManager1) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="No" {{ old('validationManager1', $maadiran->validationManager1) == 'No' ? 'checked' : '' }}>
=======
                                                @if($isManager1)
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات مدیر مالی</label>
                                                      <textarea class="form-control" name="descriptionManager1" rows="3" {{ $isManager1 ? '' : 'readonly' }}>{{ old('descriptionManager1', $maadiran->descriptionManager1) }}</textarea>
                                                      @error('descriptionManager1')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Pending"
                                                                  {{ old('validationManager1', $maadiran->validationManager1) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Yes"
                                                                  {{ old('validationManager1', $maadiran->validationManager1) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="No"
                                                                  {{ old('validationManager1', $maadiran->validationManager1) == 'No' ? 'checked' : '' }}>
>>>>>>> 26b23e8 (final)
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-4 mt-4">
                                                      <label class="form-label">نتیجه بررسی مدیر مالی</label>
<<<<<<< HEAD
                                                      <input type="text" class="form-control" value="{{ $maadiran->validationManager1 === 'Yes' ? 'تأیید شده' : ($maadiran->validationManager1 === 'No' ? 'عدم تأیید' : '---') }}" readonly>
=======
                                                      <h6 class="badge bg-body-secondary text-black mb-3" readonly>{{ $maadiran->validationManager1 === 'Yes' ? 'تأیید شده' : ($maadiran->validationManager1 === 'No' ? 'عدم تأیید' : ($maadiran->validationManager1 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
>>>>>>> 26b23e8 (final)
                                                </div>
                                                @endif
                                          </div>
                                          @endif

                                          @php
<<<<<<< HEAD
                                          $isManager2 = auth()->check() && auth()->user()->role === 'manager2';
=======
                                          $isManager2 = auth()->check() && in_array(auth()->user()->role, ['manager2','admin']);
>>>>>>> 26b23e8 (final)
                                          @endphp

                                          @if($maadiran->validationManager1 === 'Yes')
                                          <hr />
                                          <div class="text-center mt-4 mb-4">
                                                <h4>تاییدیه توسط رییس کمیته رفاهی</h4>
                                          </div>
                                          <div class="row">
                                                @if($isManager2)
<<<<<<< HEAD
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
=======
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">مبلغ نهایی (تومان)</label>
                                                      <input name="finalPrice" type="text" class="form-control"
                                                            value="{{ old('finalPrice', $maadiran->finalPrice ?? $maadiran->price) }}"
                                                            {{ $isManager2 ? '' : 'readonly' }}>
                                                      @error('finalPrice')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="descriptionManager2" rows="3" {{ $isManager2 ? '' : 'readonly' }}>{{ old('descriptionManager2', $maadiran->descriptionManager2) }}</textarea>
                                                      @error('descriptionManager2')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>

                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Pending"
                                                                  {{ old('validationManager2', $maadiran->validationManager2) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
>>>>>>> 26b23e8 (final)
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Yes" {{ old('validationManager2', $maadiran->validationManager2) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="No" {{ old('validationManager2', $maadiran->validationManager2) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-4 mt-4">
                                                      <label class="form-label">نتیجه بررسی رییس کمیته رفاهی</label>
<<<<<<< HEAD
                                                      <input type="text" class="form-control" value="{{ $maadiran->validationManager2 === 'Yes' ? 'تأیید شده' : ($maadiran->validationManager2 === 'No' ? 'عدم تأیید' : '---') }}" readonly>
=======
                                                      <h6 class="badge bg-body-secondary text-black mb-3" readonly>{{ $maadiran->validationManager2 === 'Yes' ? 'تأیید شده' : ($maadiran->validationManager2 === 'No' ? 'عدم تأیید' : ($maadiran->validationManager2 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
>>>>>>> 26b23e8 (final)
                                                </div>
                                                @endif
                                          </div>
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