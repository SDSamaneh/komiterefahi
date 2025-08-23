<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        @php

                        $user = auth()->user();

                        // مجوزهای دسترسی
                        $canEditUserFields = $user && in_array($user->role, ['subscriber', 'author']) && $imprest->status !== 'Yes';
                        $canEditHR = $user && $user->role === 'humanResources';
                        $canEditManagerHr = $user && $user->role === 'managerHr';
                        $canEditManager1 = $user && $user->role === 'manager1';
                        $canEditManager2 = $user && in_array($user->role, ['manager2', 'admin']);


                        $steps = [
                        ['key' => 'accept', 'label' => 'ثبت درخواست'],
                        ['key' => 'status', 'label' => 'تأیید مدیر واحد'],
                        ['key' => 'validationHr', 'label' => 'اعتبارسنجی'],
                        ['key' => 'validation_managerHr', 'label' => 'تاییدیه مدیر منابع انسانی'],
                        ['key' => 'validationManager1', 'label' => 'تأیید مدیر مالی'],
                        ['key' => 'validationManager2', 'label' => 'تأیید نهایی'],
                        ];

                        // پیدا کردن مرحله فعلی
                        $currentStep = 1;
                        foreach ($steps as $index => $step) {
                        if (!empty($imprest->{$step['key']}) && $imprest->{$step['key']} === 'Yes') {
                        $currentStep = $index + 1;
                        } else {
                        break;
                        }
                        }

                        @endphp

                        <!-- راهنمای مراحل -->
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

                                          <!-- اعتبارسنجی -->
                                          @if($imprest->status === 'Yes')

                                          <hr />
                                          <h4 class="text-center mt-4 mb-4">اعتبارسنجی منابع انسانی</h4>
                                          <div class="row">
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">تاریخ ورود به سازمان</label>
                                                      <div class="input-container">
                                                            <input type="text" name="memberDate" class="form-control persian-date"
                                                                  value="{{ old('memberDate', $imprest->memberDate) }}"
                                                                  placeholder="به طور مثال : 1402/02/30"
                                                                  {{ $canEditHR ? '' : 'readonly' }} autocomplete="off">
                                                      </div>
                                                      @error('memberDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ سرمایه گذاری در صندوق(تومان)</label>
                                                      <input name="memberPrice" type="text" class="form-control"
                                                            value="{{ old('memberPrice', $imprest->memberPrice) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('memberPrice')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">آخرین حقوق دریافتی(تومان)</label>
                                                      <input name="lastSalary" type="text" class="form-control"
                                                            value="{{ old('lastSalary', $imprest->lastSalary) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('lastSalary')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">تاریخ اعتبار سنجی</label>
                                                      <div class="input-container">
                                                            <input name="validationDate" type="text" class="form-control persian-date"
                                                                  value="{{ old('validationDate', $imprest->validationDate) }}"
                                                                  placeholder="به طور مثال : 1402/02/30"
                                                                  {{ $canEditHR ? '' : 'readonly' }}>
                                                      </div>
                                                      @error('validationDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">میزان بدهی در زمان بهره برداری از امکانات رفاهی</label>
                                                      <table class="table table-bordered table-sm debt-table">
                                                            <thead>
                                                                  <tr>
                                                                        <th>عنوان</th>
                                                                        <th>مبلغ (تومان)</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  <tr>
                                                                        <td>وام شرکت</td>
                                                                        <td>
                                                                              <input type="text" class="form-control debt-input" name="debt_company"
                                                                                    value="{{ old('debt_company', $imprest->debt_company ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>مادیران</td>
                                                                        <td>
                                                                              <input type="text" class="form-control debt-input" name="debt_madiran"
                                                                                    value="{{ old('debt_madiran', $imprest->debt_madiran ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>وام صندوق</td>
                                                                        <td>
                                                                              <input type="text" class="form-control debt-input" name="debt_fund"
                                                                                    value="{{ old('debt_fund', $imprest->debt_fund ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>خرید از شرکت</td>
                                                                        <td>
                                                                              <input type="text" class="form-control debt-input" name="debt_purchase"
                                                                                    value="{{ old('debt_purchase', $imprest->debt_purchase ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                            </tbody>
                                                      </table>
                                                      @error('debt')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                      <label class="form-label">توضیحات</label>
                                                      <textarea class="form-control" name="descriptionHr" rows="3" {{ $canEditHR ? '' : 'readonly' }}>{{ old('descriptionHr') }}</textarea>
                                                      @error('descriptionHr')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                @if($canEditHR)
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Pending"
                                                                  {{ old('validationHr', $imprest->validationHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Yes"
                                                                  {{ old('validationHr', $imprest->validationHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">انجام شد</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="No"
                                                                  {{ old('validationHr', $imprest->validationHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">بررسی نشده</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                      <div class="col-md-6">
                                                            <label class="form-label">اعتبارسنجی</label>
                                                            <h6 class="badge bg-body-secondary text-black mb-3">{{ $imprest->validationHr === 'Yes' ? 'انجام شد' : ($imprest->validationHr === 'No' ? 'انجام نشود' : ($imprest->validationHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                      </div>
                                                </div>
                                                @endif
                                          </div>
                                          @endif

                                          {{-- تاییدیه منابع انسانی --}}
                                          @if($imprest->validationHr === 'Yes')
                                          <hr />
                                          <h4 class="text-center mt-4 mb-4">تاییدیه مدیر منابع انسانی</h4>
                                          @if($canEditManagerHr)
                                          <div class="col-md-4 mt-4 d-flex gap-4">
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="validation_managerHr" value="Pending"
                                                            {{ old('validation_managerHr', $imprest->validation_managerHr) == 'Pending' ? 'checked' : '' }}>
                                                      <label class="form-check-label">در حال بررسی</label>
                                                </div>
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="validation_managerHr" value="Yes"
                                                            {{ old('validation_managerHr', $imprest->validation_managerHr) == 'Yes' ? 'checked' : '' }}>
                                                      <label class="form-check-label">تأیید</label>
                                                </div>
                                                <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="validation_managerHr" value="No"
                                                            {{ old('validation_managerHr', $imprest->validation_managerHr) == 'No' ? 'checked' : '' }}>
                                                      <label class="form-check-label">عدم تأیید</label>
                                                </div>
                                          </div>
                                          @else
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <label class="form-label">نتیجه بررسی مدیر منابع انسانی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $imprest->validation_managerHr === 'Yes' ? 'تأیید شده' : ($imprest->validation_managerHr === 'No' ? 'عدم تأیید' : ($imprest->validation_managerHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                          </div>
                                          @endif
                                          @endif


                                          {{-- تاییدیه مدیر مالی --}}
                                          @if($imprest->validation_managerHr === 'Yes')
                                          <hr />
                                          <h4 class="text-center mt-4 mb-4">تاییدیه مدیر مالی</h4>

                                          @if($canEditManager1)
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات مدیر مالی</label>
                                                      <textarea class="form-control" name="descriptionManager1" rows="3" {{ $canEditManager1 ? '' : 'readonly' }}>{{ old('descriptionManager1', $imprest->descriptionManager1) }}</textarea>
                                                      @error('descriptionManager1')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Pending"
                                                                  {{ old('validationManager1', $imprest->validationManager1) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Yes"
                                                                  {{ old('validationManager1', $imprest->validationManager1) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="No"
                                                                  {{ old('validationManager1', $imprest->validationManager1) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                          </div>
                                          @else
                                          <div class="row">
                                                <div class="col-md-6">
                                                      <label class="form-label">توضیحات مدیر مالی</label>
                                                      <p class="form-control-plaintext  bg-body-secondary">{{ $imprest->descriptionManager1 }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                      <label class="form-label">نتیجه بررسی مدیر مالی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $imprest->validationManager1 === 'Yes' ? 'تأیید شده' : ($imprest->validationManager1 === 'No' ? 'عدم تأیید' : ($imprest->validationManager1 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                          </div>
                                          @endif

                                          @endif
                                          {{-- تاییدیه رییس کمیته --}}
                                          @if($imprest->validationManager1 === 'Yes')
                                          <hr />
                                          <h4 class="text-center mt-4 mb-4">تاییدیه رییس کمیته رفاهی</h4>
                                          @if($canEditManager2)
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">مبلغ نهایی (تومان)</label>
                                                      <input name="finalPrice" type="text" class="form-control"
                                                            value="{{ old('finalPrice', $imprest->finalPrice ?? $imprest->price) }}"
                                                            {{ $canEditManager2 ? '' : 'readonly' }}>
                                                      @error('finalPrice')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="descriptionManager2" rows="3" {{ $canEditManager2 ? '' : 'readonly' }}>{{ old('descriptionManager2', $imprest->descriptionManager2) }}</textarea>
                                                      @error('descriptionManager2')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Pending"
                                                                  {{ old('validationManager2', $imprest->validationManager2) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Yes" {{ old('validationManager2', $imprest->validationManager2) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="No" {{ old('validationManager2', $imprest->validationManager2) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                          </div>
                                          @else
                                          <div class="row">
                                                <div class="col-md-4">
                                                      <label class="form-label">مبلغ نهایی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $imprest->finalPrice }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                      <label class="form-label">توضیحات رییس کمیته رفاهی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $imprest->descriptionManager2 }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                      <label class="form-label">نتیجه بررسی رییس کمیته رفاهی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $imprest->validationManager2 === 'Yes' ? 'تأیید شده' : ($imprest->validationManager2 === 'No' ? 'عدم تأیید' : ($imprest->validationManager2 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
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