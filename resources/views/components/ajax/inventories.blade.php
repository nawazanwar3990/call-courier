<div class="card p-0">
    <div class="card-header p-0">
        <h4 class="card-title">Inventories for {{ $giftCard->name }}</h4>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover table-sm">
            <thead class="table-primary">
            <tr>
                <th>{{ trans('general.redeem_code') }}</th>
                <th>{{ trans('general.expire_date') }}</th>
                <th>{{ trans('general.status') }}</th>
                <th>{{ trans('general.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->redeem_code }}</td>
                    <td>{{ \Carbon\Carbon::parse($inventory->expire_date)->format('d M Y') }}</td>
                    <td>
                            <span class="badge bg-success">
                                {{ \App\Enums\InventoryStatusEnum::getTranslationKeyBy($inventory->status) }}
                            </span>
                    </td>
                    <td class="text-center">
                        <input type="radio" name="inventory_id"
                               value="{{ $inventory->id }}" {{ $loop->first ? 'checked' : '' }}>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No available inventories found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
