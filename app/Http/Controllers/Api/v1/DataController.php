<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class DataController extends BaseController
{

    public function getCities()
    {
        $cities = City::get()->pluck('name', 'id');

        return $this->sendResponse($cities,'Cities');
    }

    public function getDistricts(City $city)
    {
        $district = $city->districts()->pluck('name', 'id');

        return $this->sendResponse($district,'Districts');
    }
}
