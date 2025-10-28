@foreach($tasks as $task)
    @php
        $submission_limit = $task->submissions_count;
        $task_limit = $task->task_limit;
    @endphp
    @if($task->task_limit == 0 OR $submission_limit < $task_limit)
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 mb-4">
            <div class="card position-relative">
                @php $s = $task->userSubmissions[0] ?? null;@endphp
                @if($s && $s->status===\App\Enums\SubmissionStatusEnum::APPROVED)
                    <span class="position-absolute top-0 end-0 badge bg-success text-white m-2 z-3">
                        {{ __('general.completed') }}
                    </span>
                @endif
                <div class="image-box" style="">
                    <a href="{{route('website.task.detail',$task->id)}}">
                        <img
                            src="{{ $task->getFirstMediaUrl('picture') }}"
                            alt="client logo" class="task-card-img"/>
                    </a>
                </div>
                <div class="card-body d-flex flex-column justify-content-between task-card-footer">
                    <h5 class="card-title">
                        <a href="{{route('website.task.detail',$task->id)}}">{{ $task->task_name }}</a>
                    </h5>
                    <div class="gap-2">
                        <span class="badge rounded-pill bg-danger text-white">
                            <i class="fa-solid fa-coins me-1"></i> {{ $task->set_coins }}
                        </span>
                        <span class="badge rounded-pill bg-info text-white text-wrap mt-1">
                            <i class="fa-solid fa-file-image me-1"></i> Complete offer
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
