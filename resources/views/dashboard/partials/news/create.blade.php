<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        <div class="card border">
                              <div class="col-12 text-center mb-3 mt-3">
                                    <h1 class="mb-0 h3">ثبت اطلاعیه</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{route('news.store')}}" method="post">
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
                                                <div class="col-md-4 mt-3">
                                                      <label class="form-label">عنوان</label>
                                                      <input name="title" type="text" class="form-control">
                                                      @error('name')
                                                      <small class="mt-2 d-inline-block text-danger">{{$message}}</small>
                                                      @enderror
                                                </div>

                                                <div class="col-md-8 mt-3">
                                                      <label class="form-label">توضیحات کوتاه</label>
                                                      <input type="text"
                                                            class="form-control"
                                                            name="shortDescription"
                                                            value="">
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                                </div>

                                                <div class="col-md-12 mt-5 text-end">
                                                      <button class="btn btn-success" type="submit">انتشار</button>
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