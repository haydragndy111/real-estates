<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ApiAboutResource;
use App\Http\Resources\ApiContactResource;
use App\Http\Resources\ApiFaqResource;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    public function getFaqData()
    {
        $faqs = Faq::all();

        $faqsCollection = ApiFaqResource::collection($faqs);

        return response()->json([
            'data'=> $faqsCollection,
        ], 200);
    }

    public function getContactData()
    {
        $setting = Setting::first();

        $settingsCollection = ApiContactResource::make($setting);

        return response()->json([
            'data'=> $settingsCollection,
        ], 200);
    }

    public function getAboutData()
    {
        $setting = Setting::first();

        $settingsCollection = ApiAboutResource::make($setting);

        return response()->json([
            'data'=> $settingsCollection,
        ], 200);
    }
}
