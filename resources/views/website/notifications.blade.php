<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h3 class="mb-0">{{ trans('general.notifications') }}</h3>
            <a onclick="readNotification('all',null,'{{\App\Enums\NotificationPositionEnum::WEBSITE_LIST}}');"
               class="text-primary text-decoration-none d-flex align-items-center cursor-pointer mark-all-read-btn">
                {{ trans('general.mark_as_read_all') }}
            </a>
        </div>
        <div class="notification-parent">
            @forelse($notifications as $notification)
                <div class="card shadow-sm mb-3 position-relative notification_holder_{{$notification->id}}">
                    <div class="card-body d-flex">
                        <div>
                            <h6 class="card-title mb-1">{!! $notification->data['heading'] !!}</h6>
                            <div class="card-text text-muted mb-0">
                                {!! $notification->data['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm text-center p-3">
                    No Notification Found
                </div>
            @endforelse
        </div>
    </div>
</x-website-layout>
