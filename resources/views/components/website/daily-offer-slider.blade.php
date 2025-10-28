<section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ trans('general.daily_offers') }}</h3>
            <a href="{{route('website.branches.list')}}"
               class="text-primary text-decoration-none d-flex align-items-center">
                {{ trans('general.view_all') }} <i class="ti ti-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row align-items-center gx-0 gy-4 g-lg-5">
            <div class="swiper-reviews-carousel overflow-hidden mb-3 pb-md-2 pb-md-3">
                <div class="swiper" id="swiper-reviews">
                    <div class="swiper-wrapper">
                        @foreach($dailyOffers as $task)
                            @php
                                $submission_limit = $task->submissions_count;
                                $task_limit = $task->task_limit;
                            @endphp
                            @if($task->task_limit == 0 OR $submission_limit < $task_limit)
                                <div class="swiper-slide">
                                    <div class="card h-100 position-relative">
                                        @php $s = $task->userSubmissions[0] ?? null;@endphp
                                        @if($s && $s->status===\App\Enums\SubmissionStatusEnum::APPROVED)
                                            <span class="position-absolute top-0 end-0 badge bg-success text-white m-2 z-3">
                                                {{ __('general.completed') }}
                                            </span>
                                        @endif
                                        <div class="image-box" style="height: 150px; overflow: hidden;">
                                            <a href="{{ route('website.task.detail', $task->id) }}">
                                                <img
                                                    src="{{ $task->getFirstMediaUrl('picture') }}"
                                                    alt="{{ $task->task_name }}"
                                                    onerror="this.src='{{ asset('assets/img/default.png') }}'"
                                                    class="card-img-top object-fit-cover"
                                                />
                                            </a>
                                        </div>

                                        <div class="card-body d-flex flex-column justify-content-between h-100">
                                            <h5 class="card-title">
                                                <a href="{{ route('website.task.detail', $task->id) }}">{{ $task->task_name }}</a>
                                            </h5>

                                            <div class="gap-2">
                                                <span class="badge rounded-pill bg-danger text-white">
                                                    <i class="fa-solid fa-coins me-1"></i> {{ $task->set_coins }}
                                                </span>
                                                <span class="badge rounded-pill bg-info text-white text-wrap mt-1">
                                                    <i class="fa-solid fa-file-image me-1"></i>
                                                    {{ trans('general.complete_offer') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="swiper-button-next" hidden=""></div>
                    <div class="swiper-button-prev" hidden=""></div>
                </div>
            </div>
        </div>
    </div>
</section>
