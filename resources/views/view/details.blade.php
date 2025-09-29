@extends('layouts.dashboard.master')
@section('content')
<main>
      <!-- Main contain START -->
      <section class="py-4">
            <div class="container">
                  <div class="row justify-content-center">
                        <div class="col-lg-10">

                              <!-- کارت خبر -->
                              <div class="card shadow-lg border-0 rounded-4">
                                    <!-- هدر خبر -->
                                    <div class="card-header bg-primary text-white rounded-top-4 py-4">
                                          <h2 class="mb-0">{{ $news->title }}</h2>
                                          <small class="d-block mt-2">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ jdate($news->created_at)->format('Y/m/d') }}
                                          </small>
                                    </div>

                                    <!-- بدنه خبر -->
                                    <div class="card-body p-4">
                                          @if($news->shortDescription)
                                          <p class="lead text-secondary mb-4">
                                                {{ $news->shortDescription }}
                                          </p>
                                          @endif

                                          <div class="news-content fs-5 lh-lg text-dark">
                                                {!! nl2br(e($news->description)) !!}
                                          </div>
                                    </div>

                                    <!-- فوتر -->
                                    <div class="card-footer bg-light d-flex justify-content-between align-items-center rounded-bottom-4">
                                          <a href="{{ route('user_news.index') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-arrow-right me-1"></i> بازگشت به لیست اخبار
                                          </a>
                                          <span class="text-muted small">
                                                آخرین بروزرسانی: {{ jdate($news->updated_at)->format('Y/m/d H:i') }}
                                          </span>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </section>
      <!--Main contain END -->
</main>
@endsection