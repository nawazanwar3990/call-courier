<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <h3 class="my-4">{{$pageTitle}}</h3>
        <div class="row mb-3">
            @include('components.website.task-cards')
        </div>
    </div>
</x-website-layout>
