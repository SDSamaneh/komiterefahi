<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        <div class="card border">
                              <div class="col-12 text-center mb-3 mt-3">
                                    <h1 class="mb-0 h3">درخواست مساعده</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{route('imprest.store')}}" method="post">
                                          @csrf
                                          <div class="row">
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
                                          </div>
                                          <div class="row">
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">نام و نام خانوادگی</label>
                                                            <input name="name" type="text" class="form-control"
                                                                  value="{{ old('name', Auth::user()->name) }}" readonly>
                                                            @error('name')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">کدملی</label>
                                                            <input name="idCard" type="text" class="form-control" value="{{ old('idCard', Auth::user()->idCard) }}" readonly>
                                                            @error('idCard')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">مبلغ درخواستی (تومان)</label>
                                                            <input name="price" type="text" class="form-control" id="priceInput"
                                                                  value="{{ old('price') }}">
                                                            @error('price')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-3">
                                                      <div class="mb-3">
                                                            <label class="form-label">محل خدمت (تابع)</label>
                                                            <select name="loc" class="form-select">
                                                                  <option value="" selected disabled>یک گزینه را انتخاب کنید</option>
                                                                  <option value="یکتاز">یکتاز</option>
                                                                  <option value="اوراسیا">اوراسیا</option>
                                                            </select>
                                                            @error('loc')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                      <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" name="status" value="Yes" id="status">
                                                            <label class="form-check-label" for="status">
                                                                  درخواست مساعده دارم
                                                            </label>
                                                            @error('status')
                                                            <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                            @enderror
                                                      </div>
                                                </div>
                                                <div class="col-md-6 mt-3 text-end">
                                                      <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                                                      <a href="{{route('index')}}" class="btn btn-warning">انصراف</a>
                                                </div>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>