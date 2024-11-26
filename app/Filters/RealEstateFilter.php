<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RealEstateFilter
{
    /**
     * Apply filters based on the request input.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @return Builder
     */

    public static function apply($query, Request $request)
    {
        $priceByUser = User::getPriceByUser();

        $cityId = $request->input('city_id');
        $districtId = $request->input('district_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minRooms = $request->input('min_rooms');
        $maxRooms = $request->input('max_rooms');
        $type = $request->input('type');

        // dd($query->get());
        return $query
            ->when($cityId, function ($q) use ($cityId) {
                $q->whereHas('city', function ($query) use ($cityId) {
                    $query->where('cities.id', $cityId);
                });
            })
            ->when($districtId, function ($q) use ($districtId) {
                $q->where('district_id', $districtId);
            })
            ->when($minPrice || $maxPrice, fn($q) => self::applyPriceFilter($q, $minPrice, $maxPrice, $priceByUser))
            ->when($minRooms || $maxRooms, fn($q) => self::applyRoomsFilter($q, $minRooms, $maxRooms))
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            });
    }

    protected static function applyPriceFilter(Builder $query, $minPrice, $maxPrice, string $priceByUser): void
    {
        $query->where(function ($q) use ($minPrice, $maxPrice, $priceByUser) {
            if ($minPrice && $maxPrice) {
                // Case: Between min and max
                $q->whereBetween($priceByUser, [$minPrice, $maxPrice]);
            } elseif ($minPrice) {
                // Case: Only min price
                $q->where($priceByUser, '>=', $minPrice);
            } elseif ($maxPrice) {
                // Case: Only max price
                $q->where($priceByUser, '<=', $maxPrice);
            }
        });
    }

    protected static function applyRoomsFilter(Builder $query, $minRooms, $maxRooms): void
    {
        $query->where(function ($q) use ($minRooms, $maxRooms) {
            if ($minRooms && $maxRooms) {
                // Case: Between min and max rooms
                $q->whereBetween('rooms', [$minRooms, $maxRooms]);
            } elseif ($minRooms) {
                // Case: Only min rooms
                $q->where('rooms', '>=', $minRooms);
            } elseif ($maxRooms) {
                // Case: Only max rooms
                $q->where('rooms', '<=', $maxRooms);
            }
        });
    }
}
