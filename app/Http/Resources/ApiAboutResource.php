<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiAboutResource extends JsonResource
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
            'header_title' => $setting->header_title,
            'header_text' => $setting->header_text,
            'content' => $setting->content,
        ];
    }
}
