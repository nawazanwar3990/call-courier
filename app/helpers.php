<?php

use App\Enums\CacheEnum;
use App\Enums\ContactTypeEnum;
use App\Enums\StageBookingTypeEnum;
use App\Enums\TableEnum;
use App\Enums\TextStyleEnum;
use App\Models\Accounts\AccountHead;
use App\Models\Accounts\Transaction;
use App\Models\Marquee\Booking;
use App\Models\Marquee\Stage;
use App\Services\BusinessService;
use App\Services\MarqueeService;
use App\Services\SystemSettingsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

if (! function_exists('formatText')) {
    /**
     * Format text to software-specific format
     * @param string $text
     * @return string
     */
    function formatText(string|null $text): string
    {
        if (is_null($text)) {
            return '';
        }

        $style = SystemSettingsService::getTextStyle();
        return match($style) {
            TextStyleEnum::CAPITAL_LETTERS => str($text)->upper()->toString(),
            TextStyleEnum::SMALL_LETTERS => str($text)->lower()->toString(),
            TextStyleEnum::PROPER_LETTERS => str($text)->title()->toString(),
            TextStyleEnum::AS_TYPED => $text,
        };
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format date to software-specific format
     * @param $date
     * @return string
     */
    function formatDate($date): string
    {
        return Carbon::parse($date)->format(SystemSettingsService::getDateFormat());
    }
}

if (! function_exists('formatNumber')) {
    /**
     * format number for a better view
     * @param $number
     * @param int $decimals
     * @return string|null
     */
    function formatNumber($number, int $decimals = 2): ?string
    {
        if (is_null($number)) {
            return '';
        }

        $showDecimal = false;
        $parts = explode('.', $number);
        if (count($parts) > 1 && $parts[1] > 0) {
            $showDecimal = true;
        }
        if ($number <= 0) {
            $showDecimal = true;
        }

        return number_format(floatval($number), ($showDecimal ? $decimals : 0), '.', ',');
    }
}

if (! function_exists('formatQuantity')) {
    /**
     * format quantity for a better view
     * @param $quantity
     * @param int $decimals
     * @return string|null
     */
    function formatQuantity($quantity, int $decimals = 2): ?string
    {
        if (is_null($quantity)) {
            return '';
        }

        $showDecimal = false;
        $parts = explode('.', $quantity);
        if (count($parts) > 1 && $parts[1] > 0) {
            $showDecimal = true;
        }

        return number_format(floatval($quantity), ($showDecimal ? $decimals : 0), '.', '');
    }
}

if (! function_exists('ledgerBalanceType')) {
    function ledgerBalanceType($balance, bool $forReport = false): string
    {
        if ($forReport) {
            return ($balance >= 0) ? formatNumber($balance) : ('(' . formatNumber(($balance * -1)) . ')');
        }
        return ($balance >= 0) ? "DR " . formatNumber($balance) : "CR " . formatNumber(($balance * -1));
    }
}

if (! function_exists('isCustomerCnicRequired')) {
    function isCustomerCnicRequired(): bool
    {
        return SystemSettingsService::isCustomerCnicRequired();
    }
}

if (! function_exists('isSupplierCnicRequired')) {
    function isSupplierCnicRequired(): bool
    {
        return SystemSettingsService::isSupplierCnicRequired();
    }
}

if (! function_exists('isDaigSystem')) {
    /**
     * Determine either system running on daig functionality or not
     * @return bool
     */
    function isDaigSystem(): bool
    {
        return config('eventory.daig_system');
    }
}

if (! function_exists('printFontSize')) {
    /**
     * Get font size for print-outs
     * @return int
     */
    function printFontSize(): int
    {
        return SystemSettingsService::getSystemSettings()->print_font_size;
    }
}

if (! function_exists('showUrduName')) {
    /**
     * Check either to show urdu name of items on prints or not
     * @return bool
     */
    function showUrduName(): bool
    {
        return SystemSettingsService::getSystemSettings()->show_urdu_name_on_prints;
    }
}

if (! function_exists('showUrduNameOnKitchenSheet')) {
    /**
     * Check either to show urdu name of items on kitchen sheet or not
     * @return bool
     */
    function showUrduNameOnKitchenSheet(): bool
    {
        return SystemSettingsService::getSystemSettings()->show_urdu_name_on_kitchen_sheet;
    }
}

if (! function_exists('eventReceivedAmount')) {
    /**
     * Get received amount against an event booking
     * @param int $bookingId
     * @param bool $excludeDiscountVouchers
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function eventReceivedAmount(int $bookingId, bool $excludeDiscountVouchers = true, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetEventCache($bookingId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = ($excludeDiscountVouchers ? CacheEnum::EVENT_RECEIVED_AMOUNT_EXCLUDE_DISCOUNT : CacheEnum::EVENT_RECEIVED_AMOUNT).$bookingId;

        return Cache::rememberForever($cacheKey, function () use ($bookingId, $excludeDiscountVouchers, $locationID) {
            $booking = Booking::query()
                ->where('business_location_id', $locationID)
                ->select(['id', 'customer_id'])
                ->find($bookingId);

            $bookingCustomerAccountHead = AccountHead::where('business_location_id', $locationID)
                ->where('account_type', ContactTypeEnum::CUSTOMER)
                ->where('account_id', $booking->customer_id)
                ->value('HeadCode');

            $amount = Transaction::query()
                ->whereHas('booking', function ($query) use ($bookingId) {
                    $query->where(TableEnum::BOOKINGS . '.id', $bookingId)
                        ->orWhere(TableEnum::BOOKINGS . '.parent_booking_id', $bookingId);
                })
                ->when($excludeDiscountVouchers, function ($query) {
                    $query->where('vType', '!=', 'Discount');
                })
                ->where('COAID', $bookingCustomerAccountHead)
                ->whereNotIn('vType', ['Adjustment', 'CR-Cancel'])
                ->selectRaw('IFNULL(SUM(Credit), 0) received_amount')
                ->first();

            return $amount->received_amount;
        });
    }
}

if (! function_exists('eventNetTotalAmount')) {
    /**
     * Get net total amount against an event booking and its addon bookings
     * @param int $bookingId
     * @param bool $withAddonBookings
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function eventNetTotalAmount(int $bookingId, bool $withAddonBookings = false, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetEventCache($bookingId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::EVENT_NET_TOTAL.$bookingId;

        return Cache::rememberForever($cacheKey, function () use ($bookingId, $withAddonBookings, $locationID) {
            $bookingNetTotal = Booking::where('business_location_id', $locationID)
                ->where('id', $bookingId)
                ->when($withAddonBookings, function (Builder $query) use ($bookingId) {
                    $query->orWhere('parent_booking_id', $bookingId);
                })
                ->selectRaw('IFNULL(SUM(net_total), 0) net_total, event_no')
                ->groupBy('event_no')
                ->get()
                ->sum('net_total');

            $stageNetTotal = Stage::where('business_location_id', $locationID)
                ->where('booking_id', $bookingId)
                ->selectRaw('IFNULL(SUM(net_total), 0) net_total')
                ->get()
                ->sum('net_total');

            return ($bookingNetTotal + $stageNetTotal);
        });
    }
}

if (! function_exists('eventGrandTotalAmount')) {
    /**
     * Get grand total amount against an event booking and its addon bookings
     * @param int $bookingId
     * @param bool $withAddonBookings
     * @param int|null $businessLocationId
     * @return mixed
     */
    function eventGrandTotalAmount(int $bookingId, bool $withAddonBookings = false, int|null $businessLocationId = null): mixed
    {
        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::EVENT_GRAND_TOTAL.$bookingId;

        return Cache::rememberForever($cacheKey, function () use ($bookingId, $withAddonBookings, $locationID) {
            $bookingGrandTotal = Booking::where('business_location_id', $locationID)
                ->where('id', $bookingId)
                ->when($withAddonBookings, function (Builder $query) use ($bookingId) {
                    $query->orWhere('parent_booking_id', $bookingId);
                })
                ->selectRaw('IFNULL(SUM(grand_total), 0) grand_total, event_no')
                ->groupBy('event_no')
                ->get()
                ->sum('grand_total');

            $stageGrandTotal = Stage::where('business_location_id', $locationID)
                ->where('booking_id', $bookingId)
                ->selectRaw('IFNULL(SUM(grand_total), 0) grand_total')
                ->get()
                ->sum('grand_total');

            return ($bookingGrandTotal + $stageGrandTotal);
        });
    }
}

if (! function_exists('eventDiscountAmount')) {
    /**
     * Get total discount amount against an event booking and its addon bookings either from booking or payment voucher
     * @param int $bookingId
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function eventDiscountAmount(int $bookingId, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetEventCache($bookingId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::EVENT_DISCOUNT_AMOUNT.$bookingId;

        return Cache::rememberForever($cacheKey, function () use ($bookingId, $locationID) {
            $booking = Booking::query()
                ->where('business_location_id', $locationID)
                ->select(['id', 'customer_id'])
                ->find($bookingId);

            $bookingCustomerAccountHead = AccountHead::where('business_location_id', $locationID)
                ->where('account_type', ContactTypeEnum::CUSTOMER)
                ->where('account_id', $booking->customer_id)
                ->value('HeadCode');

            $amount = Transaction::query()
                ->whereHas('booking', function ($query) use ($bookingId) {
                    $query->where(TableEnum::BOOKINGS . '.id', $bookingId)
                        ->orWhere(TableEnum::BOOKINGS . '.parent_booking_id', $bookingId);
                })
                ->where('COAID', $bookingCustomerAccountHead)
                ->where('vType', 'Discount')
                ->selectRaw('IFNULL(SUM(Credit), 0) discount_amount')
                ->first();

            return $amount->discount_amount;
        });
    }
}

if (! function_exists('stageReceivedAmount')) {
    /**
     * Get received amount against a stage booking
     * @param int $stageId
     * @param bool $excludeDiscountVouchers
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function stageReceivedAmount(int $stageId, bool $excludeDiscountVouchers = true, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetStageCache($stageId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = ($excludeDiscountVouchers ? CacheEnum::STAGE_RECEIVED_AMOUNT_EXCLUDE_DISCOUNT : CacheEnum::STAGE_RECEIVED_AMOUNT).$stageId;

        return Cache::rememberForever($cacheKey, function () use ($stageId, $excludeDiscountVouchers, $locationID) {

            $stage = Stage::query()
                ->where('business_location_id', $locationID)
                ->select(['id', 'customer_id', 'type', 'booking_id'])
                ->find($stageId);

            $customerID = $stage->customer_id;
            if ($stage->type === StageBookingTypeEnum::WITH_BOOKING) {
                $stage->load([
                    'booking:id,customer_id'
                ]);

                $customerID = $stage->booking->customer_id;
            }

            $stageCustomerAccountHead = AccountHead::where('business_location_id', $locationID)
                ->where('account_type', ContactTypeEnum::CUSTOMER)
                ->where('account_id', $customerID)
                ->value('HeadCode');

            $amount = Transaction::query()
                ->whereHas('stage', function ($query) use ($stageId) {
                    $query->where(TableEnum::STAGES . '.id', $stageId);
                })
                ->when($excludeDiscountVouchers, function ($query) {
                    $query->where('vType', '!=', 'Discount');
                })
                ->where('COAID', $stageCustomerAccountHead)
                ->whereNotIn('vType', ['Adjustment', 'CR-Cancel'])
                ->selectRaw('IFNULL(SUM(Credit), 0) received_amount')
                ->first();

            return $amount->received_amount;

        });
    }
}

if (! function_exists('stageNetTotalAmount')) {
    /**
     * Get net total amount against a stage booking
     * @param int $stageId
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function stageNetTotalAmount(int $stageId, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetStageCache($stageId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::STAGE_NET_TOTAL.$stageId;

        return Cache::rememberForever($cacheKey, function () use ($stageId, $locationID) {

            $stage = Stage::where('business_location_id', $locationID)
                ->where('id', $stageId)
                ->selectRaw('IFNULL(SUM(net_total), 0) net_amount')
                ->first();

            return $stage->net_amount;

        });
    }
}

if (! function_exists('stageGrandTotalAmount')) {
    /**
     * Get grand total amount against a stage booking
     * @param int $stageId
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function stageGrandTotalAmount(int $stageId, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetStageCache($stageId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::STAGE_GRAND_TOTAL.$stageId;

        return Cache::rememberForever($cacheKey, function () use ($stageId, $locationID) {

            $stage = Stage::where('business_location_id', $locationID)
                ->where('id', $stageId)
                ->selectRaw('IFNULL(SUM(grand_total), 0) grand_amount')
                ->first();

            return $stage->grand_amount;

        });
    }
}

if (! function_exists('stageDiscountAmount')) {
    /**
     * Get total discount amount against a stage booking either from booking or payment voucher
     * @param int $stageId
     * @param int|null $businessLocationId
     * @param bool $withoutCache
     * @return mixed
     */
    function stageDiscountAmount(int $stageId, int|null $businessLocationId = null, bool $withoutCache = false): mixed
    {
        if ($withoutCache) {
            MarqueeService::resetStageCache($stageId);
        }

        $locationID = $businessLocationId ?? BusinessService::getBusinessLocationId();

        $cacheKey = CacheEnum::STAGE_DISCOUNT_AMOUNT.$stageId;

        return Cache::rememberForever($cacheKey, function () use ($stageId, $locationID) {
            $stage = Stage::query()
                ->where('business_location_id', $locationID)
                ->select(['id', 'customer_id'])
                ->find($stageId);

            $stageCustomerAccountHead = AccountHead::where('business_location_id', $locationID)
                ->where('account_type', ContactTypeEnum::CUSTOMER)
                ->where('account_id', $stage->customer_id)
                ->value('HeadCode');

            $amount = Transaction::query()
                ->whereHas('stage', function ($query) use ($stageId) {
                    $query->where(TableEnum::STAGES . '.id', $stageId);
                })
                ->where('COAID', $stageCustomerAccountHead)
                ->where('vType', 'Discount')
                ->selectRaw('IFNULL(SUM(Credit), 0) discount_amount')
                ->first();

            return $amount->discount_amount;
        });
    }
}
