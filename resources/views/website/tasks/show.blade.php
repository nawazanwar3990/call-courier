<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <div class="card mx-auto w-100 task-detail-holder">
            <div class="card-header py-3">
                {{ trans('general.complete_offer_and_submit_proof') }}
            </div>
            <hr class="my-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image-box mb-3" style="height: 200px; overflow: hidden;">
                            <img
                                src="{{ $task->getFirstMediaUrl('picture') }}"
                                onerror="this.src='{{ asset('assets/img/default.png') }}'"
                                alt="client logo"
                                style="display: block; width: 100%; height: 100%; object-fit: cover;"/>
                        </div>
                        <div>
                            <div class="d-flex justify-content-start align-items-center">
                                <h5 class="card-text mb-0">{{ $task->task_name }}</h5>
                                <span class="badge rounded-pill bg-danger text-white ms-2">
                                            <i class="fa-solid fa-coins me-1"></i> {{ $task->set_coins }}
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <h5 class="card-text">
                                <i class="fa-solid fa-list-check me-2"></i>{{ trans('general.instructions') }}
                            </h5>
                            <div>
                                {!! $task->task_instruction !!}
                            </div>
                        </div>
                        <div class="mt-3">
                            <a class="btn btn-primary me-2 mb-1" href="{{ $task->task_url }}" target="_blank">
                                <i class="fa-solid fa-play me-1"></i>{{ trans('general.start_offer') }}
                            </a>
                            @isset($task->userSubmissions[0])
                                @php $alreadySubmission =$task->userSubmissions[0];@endphp
                                @if(in_array($alreadySubmission->status,[
                                    \App\Enums\SubmissionStatusEnum::APPROVED,
                                    \App\Enums\SubmissionStatusEnum::SUBMITTED,
                                    \App\Enums\SubmissionStatusEnum::RE_SUBMIT
                                ]))
                                    <a class="btn btn-outline-success mb-1 disabled text-muted">
                                        <i class="fa-solid fa-circle-check me-1"></i>{{ trans('general.already_submitted') }}
                                    </a>
                                @else
                                    <a class="btn btn-success text-white mb-1"
                                       onclick="submitTask(this, '{{ $task->id }}','{{$alreadySubmission->id}}')">
                                        <i class="fa-solid fa-upload me-1"></i>{{ trans('general.re_submit') }}
                                    </a>
                                @endif
                            @else
                                <a class="btn btn-success text-white mb-1"
                                   onclick="submitTask(this, '{{ $task->id }}',null)">
                                    <i class="fa-solid fa-upload me-1"></i>{{ trans('general.submit_proof') }}
                                </a>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
