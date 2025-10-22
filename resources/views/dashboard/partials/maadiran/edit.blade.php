<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">

                        @php

                        $user = auth()->user();
                        $canEditUserFields = $user && $user->hasAnyRole(['subscriber', 'author','humanResources','admin']);
                        $canEditHR = $user && $user->hasAnyRole(['humanResources','admin']);
                        $canEditManagerHr = $user && $user->hasAnyRole(['managerHr','admin']);

                        $steps = [
                        ['key' => 'accept', 'label' => 'ثبت درخواست'],
                        ['key' => 'status', 'label' => 'تأیید مدیر واحد'],
                        ['key' => 'validationHr', 'label' => 'اعتبارسنجی'],
                        ['key' => 'validation_managerHr', 'label' => 'تاییدیه مدیر منابع انسانی'],
                        ];

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

                        <div class="card border">
                              <div class="card-header text-center mb-3 mt-3">
                                    <h1 class="mb-3">ویرایش درخواست خرید از مادیران</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('maadiran.update', $maadiran->id) }}" method="post">
                                          @csrf
                                          @method('PUT')
                                          <div class="row">
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">نام و نام خانوادگی</label>
                                                      <input name="name" type="text" class="form-control" value="{{ old('name', $maadiran->name) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">کدملی</label>
                                                      <input name="idCard" type="text" class="form-control" value="{{ old('idCard', $maadiran->idCard) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('idCard') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ درخواستی (تومان)</label>
                                                      <input name="price" type="text" class="form-control" value="{{ old('price', $maadiran->price) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">دپارتمان</label>
                                                      @if($canEditUserFields)

                                                      <select class="form-select" name="departmans_id">
                                                            <option value="" disabled>دپارتمان را انتخاب کنید</option>

                                                            @foreach($departmans as $departman)
                                                            <option value="{{$departman->id}}" {{ old('departmans_id', $maadiran->departmans_id) == $departman->id ? 'selected' : '' }}>
                                                                  {{$departman->name}}
                                                            </option>
                                                            @endforeach

                                                      </select>

                                                      @else
                                                      <select class="form-select" disabled>
                                                            <option selected>{{ $maadiran->departmans->name }}</option>
                                                      </select>

                                                      @endif

                                                      @error('departmans_id')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مدیر واحد</label>
                                                      @if($canEditUserFields)

                                                      <select class="form-select" name="supervisors_id" aria-label="Default select example">
                                                            <option value="" disabled>مدیر واحد را انتخاب کنید</option>

                                                            @foreach($supervisors as $supervisor)
                                                            <option value="{{$supervisor->id}}" {{ old('supervisors_id', $maadiran->supervisors_id) == $supervisor->id ? 'selected' : '' }}>
                                                                  {{$supervisor->name}}
                                                            </option>
                                                            @endforeach

                                                      </select>

                                                      @else
                                                      <select class="form-select" disabled>
                                                            <option selected>{{ $maadiran->supervisor->name }}</option>
                                                      </select>
                                                      @endif

                                                      @error('supervisors_id')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">دسته بندی</label>
                                                            @if($canEditUserFields)

                                                            <select class="form-select" name="category" aria-label="Default select example" required>
                                                                  <option value="" disabled>دلیل درخواست وام را انتخاب کنید</option>

                                                                  @foreach(['لوازم خانگی', 'موبایل', 'لپتاپ', 'تلویزیون', 'سایر'] as $category)
                                                                  <option value="{{ $category }}" {{ old('category', $maadiran->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                                                  @endforeach
                                                            </select>

                                                            @else
                                                            <select class="form-select" disabled>
                                                                  <option selected>{{ $maadiran->category }}</option>
                                                            </select>
                                                            @endif

                                                            @error('category')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label class="form-label">توضیحات</label>
                                                            <textarea class="form-control" name="descriptionUser" rows="3" {{ $canEditUserFields ? '' : 'readonly' }}>{{ old('descriptionUser', $maadiran->descriptionUser) }}</textarea>
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

                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">اعتبارسنجی منابع انسانی</h4>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">تاریخ ورود به سازمان</label>
                                                      <input name="memberDate" type="text" class="form-control input-field persian-date"
                                                            value="{{ old('memberDate', $maadiran->memberDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $canEditHR ? '' : 'readonly' }} autocomplete="off">
                                                      @error('memberDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">مبلغ سرمایه گذاری در صندوق(تومان)</label>
                                                      <input name="memberPrice" type="text" class="form-control"
                                                            value="{{ old('memberPrice', $maadiran->memberPrice) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('memberPrice')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">آخرین حقوق دریافتی(تومان)</label>
                                                      <input name="lastSalary" type="text" class="form-control"
                                                            value="{{ old('lastSalary', $maadiran->lastSalary) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('lastSalary')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">تاریخ اعتبار سنجی</label>
                                                      <input name="validationDate" type="text" class="form-control persian-date"
                                                            value="{{ old('validationDate', $maadiran->validationDate) }}"
                                                            placeholder="به طور مثال : 1402/02/30"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
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
                                                                              <input type="text" class="form-control" name="debt_company"
                                                                                    value="{{ old('debt_company', $maadiran->debt_company ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>مادیران</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_madiran"
                                                                                    value="{{ old('debt_madiran', $maadiran->debt_madiran ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>وام صندوق</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_fund"
                                                                                    value="{{ old('debt_fund', $maadiran->debt_fund ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>خرید از شرکت</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_purchase"
                                                                                    value="{{ old('debt_purchase', $maadiran->debt_purchase ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                            </tbody>
                                                      </table>
                                                      <div class="col-md-4">
                                                            @error('debt_company') <small class="text-danger">{{ $message }}</small> @enderror
                                                      </div>
                                                      <div class="col-md-4">

                                                            @error('debt_madiran') <small class="text-danger">{{ $message }}</small> @enderror
                                                      </div>
                                                      <div class="col-md-4">

                                                            @error('debt_fund') <small class="text-danger">{{ $message }}</small> @enderror
                                                      </div>
                                                      <div class="col-md-4">

                                                            @error('debt_purchase') <small class="text-danger">{{ $message }}</small> @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                      <label class="form-label">توضیحات</label>
                                                      <input type="text"
                                                            class="form-control"
                                                            name="descriptionEdari"
                                                            value="{{ old('descriptionEdari', $maadiran->descriptionEdari) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                </div>
                                                @if($canEditHR)
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Pending"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Yes"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="No"
                                                                  {{ old('validationHr', $maadiran->validationHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تایید</label>

                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-12">
                                                      <label class="form-label">اعتبارسنجی</label>
                                                      <h6 class="badge bg-body-secondary text-black mb-3">{{ $maadiran->validationHr === 'Yes' ? 'تأیید' : ($maadiran->validationHr === 'No' ? 'عدم تأیید' : ($maadiran->validationHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif

                                                @if($maadiran->validationHr === 'Yes')
                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">تاییدیه مدیر منابع انسانی</h4>
                                                @if($canEditManagerHr)
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">توضیحات</label>

                                                      <input type="text"
                                                            class="form-control"
                                                            name="descriptionHr"
                                                            value="{{ old('descriptionHr', $maadiran->descriptionHr) }}"
                                                            {{ $canEditManagerHr ? '' : 'readonly' }}>

                                                      @error('descriptionHr')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="Pending"
                                                                  {{ old('validation_managerHr', $maadiran->validation_managerHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="Yes"
                                                                  {{ old('validation_managerHr', $maadiran->validation_managerHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="No"
                                                                  {{ old('validation_managerHr', $maadiran->validation_managerHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                      <label class="form-label">توضیحات</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $maadiran->descriptionHr }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                      <label class="form-label">نتیجه نهایی </label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $maadiran->validation_managerHr === 'Yes' ? 'تأیید شده' : ($maadiran->validation_managerHr === 'No' ? 'عدم تأیید' : ($maadiran->validation_managerHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif
                                                @endif
                                          </div>

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