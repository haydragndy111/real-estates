<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\RealEstateFilter;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ApiRealEstatesCollection;
use App\Models\EstateUser;
use App\Models\RealEstate;
use Illuminate\Http\Request;

class EstateUserController extends BaseController
{
    public function toggleFavourite(RealEstate $estate, Request $request)
    {
        $user = $this->user;

        // return $this->sendResponse($estate,'dasda');
        $estateUser = EstateUser::firstOrNew(['real_estate_id' => $estate->id, 'user_id' => $user->id]);

        app()->setLocale($user->profile->locale);

        $isFavorite = $estateUser->is_favourite = !$estateUser->is_favourite;
        $estateUser->save();

        $message = $isFavorite ? trans('messages.added_to_favourite')
        : trans('messages.removed_from_favourite');;
        // $user->estates()->syncWithoutDetaching($estate->id,[
        //     'is_favourite' => $favourite,
        // ]);

        return $this->sendResponse(null, $message);
    }

    public function getFavouritesEstates(Request $request)
    {
        // dd("Dasd");
        $user = $this->user;
        // dd($user);
        $estatesQuery = $user->estates()
            ->wherePivot('is_favourite', 1);
        $estates = RealEstateFilter::apply($estatesQuery, $request)
            ->paginate(8);

        $estatesCollection = new ApiRealEstatesCollection($estates);

        return response()->json([
            'data'=> $estatesCollection,
        ], 200);
    }
}
