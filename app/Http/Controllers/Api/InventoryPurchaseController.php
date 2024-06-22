<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryPurchaseService;

class InventoryPurchaseController extends Controller
{
    //

    public function __construct(Type $var = null) {
        $this->var = $var;
    }

    public function saveInventoryPurcahseDetails(Request $request,InventoryPurchaseService $inventoryPurchaseService){

          return $inventoryPurchaseService->saveInventoryPurcahseDetails();

    }
}
