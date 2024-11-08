<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiRealEstatesCollection;
use App\Http\Resources\ApiRealEstatesResource;
use App\Models\RealEstate;
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    public function index()
    {
        $estates = RealEstate::paginate(8);
        $estatesCollection = new ApiRealEstatesCollection($estates);

        return response()->json([
            'data'=> $estatesCollection,
        ], 200);
    }

    public function show(RealEstate $estate)
    {
        $estateResource = ApiRealEstatesResource::make($estate);

        return response()->json([
            'data'=> $estateResource,
        ], 200);
    }
}
