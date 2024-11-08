<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiRealEstatesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function toArray(Request $request): array
    {
        $estate = $this->resource;
        // dd($estate);
        $image = $estate->images()->main()->first()->url;
        $district = $estate->district;
        $location = $district->label.','.$district->city->label;

        return [
            'title' => $estate->title,
            'price_type' => $estate->priceType,
            'price' => $estate->aed_price,
            'is_favourite' => false,
            'image' => $image,
            'location' => $location,
            'type' => $estate->estateType,
            'size' => $estate->size,
            'rooms' => $estate->rooms,
            'handover' => $estate->handover,
            'images' => $estate->images
        ];
    }
}
