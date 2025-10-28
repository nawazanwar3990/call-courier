<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.gift_card'), 'gift_card_id')->class('form-label') }}
        {{ html()->select('gift_card_id',\App\Services\GeneralService::getGiftCardDropdown())->id('gift_card_id')->class(['form-control', 'select2'])->required()->style('width: 100%') }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.redeem_code'), 'redeem_code')->class('form-label') }}
        {{ html()->text('redeem_code')->id('redeem_code')->class('form-control')->required() }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.expire_date'), 'expire_date')->class('form-label') }}
        {{ html()->date('expire_date')->id('expire_date')->class('form-control') }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.status'), 'status')->class('form-label') }}
        {{ html()->select('status',\App\Enums\InventoryStatusEnum::getTranslationKeys())->id('status')->class(['form-control', 'select2'])->required()->style('width: 100%') }}
    </div>
</div>
