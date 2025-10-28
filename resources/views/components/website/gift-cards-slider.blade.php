<section id="landingReviews" class="section-py bg-body landing-reviews pb-0 mb-5 d-none d-lg-block d-xl-block">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3>Gift Cards</h3>
        <a href="{{ route('website.gift-cards.list') }}"
           class="text-primary text-decoration-none d-flex align-items-center">
            View All <i class="ti ti-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="row align-items-center gx-0 gy-4 g-lg-5">
        <div class="swiper-reviews-carousel overflow-hidden">
            <div class="swiper" id="swiper-gift-cards">
                <div class="swiper-wrapper">
                    @foreach($dailyGiftCards as $giftCard)
                        <div class="swiper-slide cursor-pointer"
                             onclick="applyGiftCard('{{auth()->id()}}','{{$giftCard->id}}','{{$giftCard->point_cost}}','{{$giftCard->name}}');">
                            <div class="card h-100">
                                <div class="image-box" style="height: 150px; overflow: hidden;">
                                    <a>
                                        <img src="{{ $giftCard->getFirstMediaUrl('picture') }}"
                                             alt="client logo"
                                             class="card-img-top object-fit-cover"/>
                                    </a>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <h5 class="card-title mb-2">{{ $giftCard->name }}</h5>
                                    <span class="text-dark">
                                            @include('components.coin-icon')<span
                                            class="mt-1">{{$giftCard->point_cost}}</span>
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next" hidden=""></div>
                <div class="swiper-button-prev" hidden=""></div>
            </div>
        </div>
    </div>
</section>
