<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiContactResource extends JsonResource
{
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $setting = $this->resource;

        return[
            'contact_header_title' => $setting->contact_header_title,
            'contact_header_text' => $setting->contact_header_text,
            'toll_free_number' => $setting->toll_free_number,
            'email' => $setting->email,
            'whatsapp' => $setting->whatsapp,
            'location' => $setting->location,
        ];
    }
}
