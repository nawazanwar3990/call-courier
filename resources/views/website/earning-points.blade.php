<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        @if(count($tasks)>0)
            <h3 class="my-4">{{ trans('general.daily_offers') }}</h3>
            <div class="row">
                @include('components.website.task-cards')
            </div>
        @endif
        @include('components.website.gift-cards-slider')
    </div>
</x-website-layout>
