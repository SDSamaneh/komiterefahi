<section class="py-4">
      <div class="container">
            <div class="row">
                  <div class="col-12">
                        @php

                        $user = auth()->user();

                        $canEditHR = $user && $user->hasAnyRole(['humanResources','admin']);

                        @endphp

                        <div class="card border">
                              <div class="card-header text-center mb-3 mt-3">
                                    <h1 class="mb-3">ویرایش اطلاعیه</h1>
                              </div>
                              <div class="card-body">
                                    <form action="{{ route('news.update', $news->id) }}" method="post">
                                          @csrf
                                          @method('PUT')
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
                                                @if($canEditHR)

                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">عنوان</label>
                                                      <input name="title" type="text" class="form-control" value="{{ old('title', $news->title) }}">
                                                </div>


                                                <div class="col-md-8 mt-3">
                                                      <label class="form-label">توضیحات کوتاه</label>
                                                      <input type="text"
                                                            class="form-control"
                                                            name="shortDescription"
                                                            value="{{ old('shortDescription', $news->shortDescription) }}">
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                      <label class="form-label">توضیحات تکمیلی</label>
                                                      <textarea class="form-control" name="description" rows="3">{{ old('description', $news->description) }}</textarea>
                                                </div>

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