<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiFaqResource extends JsonResource
{
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function toArray(Request $request): array
    {
        $faq = $this->resource;

        return [
            'question' => $faq->question,
            'answer' => $faq->answer,
        ];
    }
}
