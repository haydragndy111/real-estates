<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ApiRealEstatesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        $pagination = $this->resource->toArray();

        $paginationResponse = [
            'total' => $pagination['total'],
            'count' => $pagination['per_page'],
            'per_page' => $pagination['per_page'],
            'current_page' => $pagination['current_page'],
            'total_pages' => $pagination['last_page'],
            'path' => $pagination['path'],
            'previous_url' => $pagination['prev_page_url'],
            'next_url' => $pagination['next_page_url'],
        ];

        $priceType = 1;

        $estates = $this->collection->map(function($item){
            $image = $item->images()->main()->first()->url;
            $district = $item->district;
            $location = $district->label.','.$district->city->label;
            return [
                'id' => $item->id,
                'title' => $item->title,
                'price' => $item->aed_price,
                'price_type' => $item->priceType,
                'image' => $image,
                'location' => $location,
                'type' => $item->estateType,
                'size' => $item->size,
                'rooms' => $item->rooms,
                'handover' => $item->handover,
            ];
        });

        return [
            'estates' => $estates,
            'pagination' => $paginationResponse,
        ];

    }
}