<?php

namespace App\Http\Controllers\Api\v1;

use App\Constants\CurrencyConstants;
use App\Http\Controllers\BaseController;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConfigController extends BaseController
{
    public function setConfig(Request $request)
    {
        $user = $this->user;
        $profile = $this->user->profile;

        if($profile){
            return $this->sendError('User Already Has Config');
        }

        $validator = Validator::make($request->all(), [
            'locale' => [
                'required',
                Rule::in(['en','ar']),
            ],
            'currency' => [
                'required',
                Rule::in(CurrencyConstants::CURRENCY_AED,CurrencyConstants::CURRENCY_USD),
            ],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $profile = $this->user->profile()->create([
            'user_id' => $user->id,
            'locale' => $request->locale,
            'currency' => $request->currency,
        ]);

        return $this->sendResponse($profile, 'Settings Added.');
    }

    public function updateConfig(Request $request)
    {
        $user = $this->user;
        $validator = Validator::make($request->all(), [
            'locale' => [
                'required',
                Rule::in(['en','ar']),
            ],
            'currency' => [
                'required',
                Rule::in(CurrencyConstants::CURRENCY_AED,CurrencyConstants::CURRENCY_USD),
            ],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $profile = $this->user->profile;

        $profile->update([
            'locale' => $request->locale,
            'currency' => $request->currency,
        ]);

        return $this->sendResponse($profile, 'Settings Updated.');
    }

    public function getConfig(Request $request)
    {
        $profile = $this->user->profile;

        return $this->sendResponse($profile, 'Settings.');
    }
}
