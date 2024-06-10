<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'company' => 'required|min:3|max:255',
            'name' => 'required|min:3|max:255',
            'address' => 'required|min:3|max:255',
            'email' => 'required|string|email|max:100',
            'lineId' => 'required',
            'categories' => 'required|array',
            'places' => 'required|array',
            'pinLocation' => 'nullable',
            'coordinateX' => 'required',
            'coordinateY' => 'required',
            'freePic' => 'nullable',
            'displayWindows' => 'nullable',
            'artworkCountPrice' => 'nullable',
            'displayWindowsPrice' => 'nullable',
            'displayWindowsPriceYear' => 'nullable',
            'logoAtLocationMonth' => 'nullable',
            'logoAtLocation' => 'nullable',
            'reserveLogo' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'windowHeadline' => 'nullable',
            'windowText' => 'nullable',
            'websiteLink' => 'nullable',
        ];
    }
}
