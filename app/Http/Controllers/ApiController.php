<?php

namespace App\Http\Controllers;

use App\Enums\InventoryStatusEnum;
use App\Models\GiftCard;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ApiController extends Controller
{
    public function inventoriesByGiftCard(Request $request, $id): JsonResponse
    {
        $giftCard = GiftCard::find($id);
        $inventories = Inventory::where('gift_card_id', $id)
            ->where('status', InventoryStatusEnum::AVAILABLE)
            ->whereDate('expire_date', '>=', now())
            ->get();
        return response()->json([
            'success' => true,
            'html' => view('components.ajax.inventories', compact('inventories','giftCard'))->render()
        ]);
    }
}
