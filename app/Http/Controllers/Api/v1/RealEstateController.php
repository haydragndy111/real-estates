<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\RealEstateFilter;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiRealEstatesCollection;
use App\Http\Resources\ApiRealEstatesResource;
use App\Models\RealEstate;
use Illuminate\Http\Request;

class RealEstateController extends BaseController
{
    public function index(Request $request)
    {
        $estates = RealEstateFilter::apply(RealEstate::query(), $request)
            ->paginate(8);

        $estatesCollection = new ApiRealEstatesCollection($estates);

        return response()->json([
            'data'=> $estatesCollection,
        ], 200);
    }

    public function featuredEstates(Request $request)
    {
        $estates = RealEstateFilter::apply(RealEstate::featured(), $request)
            ->paginate(8);

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
