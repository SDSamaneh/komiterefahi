<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        @php

                        $user = auth()->user();

                        $canEditUserFields = $user && $user->hasAnyRole(['subscriber', 'author','humanResources','admin']);
                        $canEditHR = $user && $user->hasAnyRole(['humanResources','admin']);
                        $canEditManagerHr = $user && $user->hasAnyRole(['managerHr','admin','author']);
                        $canEditManager1 = $user && $user->hasAnyRole(['admin','manager1','author']);
                        $canEditManager2 = $user && $user->hasAnyRole(['manager2', 'admin','author']);

                        $steps = [
                        ['key' => 'accept', 'label' => 'ثبت درخواست'],
                        ['key' => 'status', 'label' => 'تأیید مدیر واحد'],
                        ['key' => 'validationHr', 'label' => 'اعتبارسنجی'],
                        ['key' => 'validation_managerHr', 'label' => 'تایید مدیر منابع انسانی'],
                        ['key' => 'validationManager1', 'label' => 'تأیید مدیر مالی'],
                        ['key' => 'validationManager2', 'label' => 'تأیید نهایی'],
                        ];

                        $currentStep = 1;
                        foreach ($steps as $index => $step) {
                        if (!empty($service->{$step['key']}) && $service->{$step['key']} === 'Yes') {
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
                                    <h1 class="mb-3">ویرایش درخواست از کویر</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('service.update', $service->id) }}" method="post">
                                          @csrf
                                          @method('PUT')
                                          <div class="row">
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">نام و نام خانوادگی</label>
                                                      <input name="name" type="text" class="form-control" value="{{ old('name', $service->name) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">کدملی</label>
                                                      <input name="idCard" type="text" class="form-control" value="{{ old('idCard', $service->idCard) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('idCard') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ درخواستی (تومان)</label>
                                                      <input name="price" type="text" class="form-control" value="{{ old('price', $service->price) }}" {{ $canEditUserFields ? '' : 'readonly' }}>
                                                      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">دپارتمان</label>
                                                      @if($canEditUserFields)
                                                      <select class="form-select" name="departmans_id">
                                                            <option value="" disabled>دپارتمان را انتخاب کنید</option>
                                                            @foreach($departmans as $departman)
                                                            <option value="{{$departman->id}}" {{ old('departmans_id', $service->departmans_id) == $departman->id ? 'selected' : '' }}>
                                                                  {{$departman->name}}
                                                            </option>
                                                            @endforeach
                                                      </select>

                                                      @else
                                                      <select class="form-select" disabled>

                                                            <option selected>{{$service->departmans->name}}</option>

                                                      </select>

                                                      @endif

                                                      @error('departmans_id')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مدیر واحد</label>
                                                      @if($canEditUserFields)
                                                      <select class="form-select" name="supervisors_id">
                                                            <option value="" disabled>مدیر واحد را انتخاب کنید</option>

                                                            @foreach($supervisors as $supervisor)
                                                            <option value="{{$supervisor->id}}" {{ old('supervisors_id', $service->supervisors_id) == $supervisor->id ? 'selected' : '' }}>
                                                                  {{$supervisor->name}}
                                                            </option>
                                                            @endforeach
                                                      </select>
                                                      @else
                                                      <select class="form-select" disabled>
                                                            <option selected>{{$service->supervisors->name}}</option>
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
                                                                  <option value="" disabled>دسته بندی را انتخاب کنید</option>
                                                                  @foreach(['خدمات تعمیرگاهی', 'موتورسیکلت بنزینی', 'موتورسیکلت برقی', 'محصولات کودک', 'دوچرخه', 'اکسسوری و لوازم جانبی', 'تفریحات آبی', 'چهار چرخ', 'سایر'] as $category)
                                                                  <option value="{{ $category }}" {{ old('category', $service->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                                                  @endforeach
                                                            </select>

                                                            @else

                                                            <select class="form-select" disabled>
                                                                  <option selected>{{ $service->category }}</option>
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
                                                            <textarea class="form-control" name="descriptionUser" rows="3" {{ $canEditUserFields ? '' : 'readonly' }}>{{ old('descriptionUser', $service->descriptionUser) }}</textarea>
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
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">تاریخ ورود به سازمان</label>
                                                      <div class="input-container">
                                                            <input name="memberDate" type="text" class="form-control persian-date"
                                                                  value="{{ old('memberDate', $service->memberDate) }}"
                                                                  placeholder="به طور مثال : 1402/02/30"
                                                                  {{ $canEditHR ? '' : 'readonly' }}
                                                                  autocomplete="off">

                                                      </div>
                                                      @error('memberDate')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">مبلغ سرمایه گذاری در صندوق( تومان )</label>
                                                      <input name="memberPrice" type="text" class="form-control"
                                                            value="{{ old('memberPrice', $service->memberPrice) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('memberPrice')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">آخرین حقوق دریافتی</label>
                                                      <input name="lastSalary" type="text" class="form-control"
                                                            value="{{ old('lastSalary', $service->lastSalary) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('lastSalary')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">تاریخ اعتبار سنجی</label>
                                                      <input name="validationDate" type="text" class="form-control persian-date"
                                                            value="{{ old('validationDate', $service->validationDate) }}"
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
                                                                                    value="{{ old('debt_company', $service->debt_company ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>مادیران</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_madiran"
                                                                                    value="{{ old('debt_madiran', $service->debt_madiran ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>وام صندوق</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_fund"
                                                                                    value="{{ old('debt_fund', $service->debt_fund ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                                  <tr>
                                                                        <td>خرید از شرکت</td>
                                                                        <td>
                                                                              <input type="text" class="form-control" name="debt_purchase"
                                                                                    value="{{ old('debt_purchase', $service->debt_purchase ?? '') }}"
                                                                                    {{ $canEditHR ? '' : 'readonly' }}>
                                                                        </td>
                                                                  </tr>
                                                            </tbody>
                                                      </table>
                                                      @error('debt_company') <small class="text-danger">{{ $message }}</small> @enderror
                                                      @error('debt_madiran') <small class="text-danger">{{ $message }}</small> @enderror
                                                      @error('debt_fund') <small class="text-danger">{{ $message }}</small> @enderror
                                                      @error('debt_purchase') <small class="text-danger">{{ $message }}</small> @enderror

                                                </div>
                                                <div class="col-md-4 mt-3">
                                                      <label class="form-label">توضیحات</label>

                                                      <input type="text"
                                                            class="form-control"
                                                            name="descriptionEdari"
                                                            value="{{ old('descriptionEdari', $service->descriptionEdari) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>

                                                </div>
                                                <div class="col-md-2 mt-3">
                                                      <label class="form-label">شماره درخواست</label>
                                                      <input name="number" type="text" class="form-control"
                                                            value="{{ old('number', $service->number) }}"
                                                            {{ $canEditHR ? '' : 'readonly' }}>
                                                      @error('number')
                                                      <small class="mt-2 d-inline-block text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                @if($canEditHR)
                                                <div class="col-md-4 mt-5 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Pending"
                                                                  {{ old('validationHr', $service->validationHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="Yes"
                                                                  {{ old('validationHr', $service->validationHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationHr" value="No"
                                                                  {{ old('validationHr', $service->validationHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-6 mt-4">
                                                      <label class="form-label">اعتبارسنجی</label>
                                                      <h6 class="badge bg-body-secondary text-black mb-3">{{ $service->validationHr === 'Yes' ? 'تایید' : ($service->validationHr === 'No' ? 'عدم تایید' : ($service->validationHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif

                                                @if($service->validationHr === 'Yes')
                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">تاییدیه مدیر منابع انسانی</h4>
                                                @if($canEditManagerHr)
                                                <div class="col-md-8 mb-3">
                                                      <label class="form-label">توضیحات</label>
                                                      <input type="text"
                                                            class="form-control"
                                                            name="descriptionHr"
                                                            value="{{ old('descriptionHr', $service->descriptionHr) }}"
                                                            {{ $canEditManagerHr ? '' : 'readonly' }}>

                                                      @error('descriptionHr')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="Pending"
                                                                  {{ old('validation_managerHr', $service->validation_managerHr) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="Yes"
                                                                  {{ old('validation_managerHr', $service->validation_managerHr) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validation_managerHr" value="No"
                                                                  {{ old('validation_managerHr', $service->validation_managerHr) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                      <label class="form-label">توضیحات</label>
                                                      <p class="form-control-plaintext  bg-body-secondary">{{ $service->descriptionHr }}</p>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                      <label class="form-label">نتیجه نهایی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $service->validation_managerHr === 'Yes' ? 'تأیید شده' : ($service->validation_managerHr === 'No' ? 'عدم تأیید' : ($service->validation_managerHr === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif
                                                @endif

                                                @if($service->validation_managerHr === 'Yes')
                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">تاییدیه مدیر مالی</h4>
                                                @if($canEditManager1)
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات مدیر مالی</label>
                                                      <textarea class="form-control" name="descriptionManager1" rows="3" {{ $canEditManager1 ? '' : 'readonly' }}>{{ old('descriptionManager1', $service->descriptionManager1) }}</textarea>
                                                      @error('descriptionManager1')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Pending"
                                                                  {{ old('validationManager1', $service->validationManager1) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="Yes"
                                                                  {{ old('validationManager1', $service->validationManager1) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager1" value="No"
                                                                  {{ old('validationManager1', $service->validationManager1) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                      <label class="form-label">توضیحات مدیر مالی</label>
                                                      <p class="form-control-plaintext  bg-body-secondary">{{ $service->descriptionManager1 }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                      <label class="form-label">نتیجه بررسی مدیر مالی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $service->validationManager1 === 'Yes' ? 'تأیید شده' : ($service->validationManager1 === 'No' ? 'عدم تأیید' : ($service->validationManager1 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
                                                </div>
                                                @endif
                                                @endif

                                                @if($service->validationManager1 === 'Yes')
                                                <hr />
                                                <h4 class="text-center mt-4 mb-4">تاییدیه رییس کمیته رفاهی</h4>
                                                @if($canEditManager2)
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">مبلغ نهایی (تومان)</label>
                                                      <input name="finalPrice" type="text" class="form-control"
                                                            value="{{ old('finalPrice', $service->finalPrice ?? $service->price) }}"
                                                            {{ $canEditManager2 ? '' : 'readonly' }}>
                                                      @error('finalPrice')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="descriptionManager2" rows="3" {{ $canEditManager2 ? '' : 'readonly' }}>{{ old('descriptionManager2', $service->descriptionManager2) }}</textarea>
                                                      @error('descriptionManager2')
                                                      <small class="text-danger">{{ $message }}</small>
                                                      @enderror
                                                </div>
                                                <div class="col-md-4 mt-4 d-flex gap-4">
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Pending"
                                                                  {{ old('validationManager2', $service->validationManager2) == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label">در حال بررسی</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="Yes" {{ old('validationManager2', $service->validationManager2) == 'Yes' ? 'checked' : '' }}>
                                                            <label class="form-check-label">تأیید</label>
                                                      </div>
                                                      <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="validationManager2" value="No" {{ old('validationManager2', $service->validationManager2) == 'No' ? 'checked' : '' }}>
                                                            <label class="form-check-label">عدم تأیید</label>
                                                      </div>
                                                </div>
                                                @else
                                                <div class="col-md-4">
                                                      <label class="form-label">مبلغ نهایی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $service->finalPrice }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                      <label class="form-label">توضیحات رییس کمیته رفاهی</label>
                                                      <p class="form-control-plaintext bg-body-secondary">{{ $service->descriptionManager2 }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                      <label class="form-label">نتیجه بررسی رییس کمیته رفاهی</label>
                                                      <h6 class="form-control-plaintext bg-body-secondary">{{ $service->validationManager2 === 'Yes' ? 'تأیید شده' : ($service->validationManager2 === 'No' ? 'عدم تأیید' : ($service->validationManager2 === 'Pending' ? 'در حال بررسی' : '---')) }}</h6>
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