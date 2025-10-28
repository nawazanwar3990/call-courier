<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <h3 class="my-4">{{$pageTitle}}</h3>
        <div class="row mb-3">
            @foreach($giftCards as $giftCard)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 cursor-pointer" onclick="applyGiftCard('{{auth()->id()}}','{{$giftCard->id}}','{{$giftCard->point_cost}}','{{$giftCard->name}}');">
                        <div class="image-box cursor-pointer">
                            <img
                                src="{{ $giftCard->getFirstMediaUrl('picture') }}"
                                alt="client logo"
                                class="card-img-top object-fit-cover"/>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between h-100 cursor-pointer">
                            <h5 class="card-title mb-2">{{ $giftCard->name }}</h5>
                            <span class="text-dark">
                                        @include('components.coin-icon')
                                <span class="mt-1">{{ $giftCard->point_cost }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-website-layout>
