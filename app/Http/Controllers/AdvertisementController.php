<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdsRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdsMail;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function create(CreateAdsRequest $request)
    {
        Log::info('$request->validated() called');
        $validatedData = $request->validated();
        Log::info($validatedData);

        $attachmentPath = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('logos', 'public');
            $attachmentPath = storage_path('app/public/' . $path);
        }

        $details = [
            'subject' => 'New Ad Submission',
            'name' => $validatedData['name'],
            'company' => $validatedData['company'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'lineId' => $validatedData['lineId'],
            'categories' => $validatedData['categories'],
            'locationRef' => $validatedData['locationRef'] ?? '',
            'placeType' => $validatedData['places'],
            'pinLocation' => $validatedData['pinLocation'] ?? '',
            'coordinateX' => $validatedData['coordinateX'],
            'coordinateY' => $validatedData['coordinateY'],
            'freePic' => $validatedData['freePic'] ?? '',
            'displayWindows' => $validatedData['displayWindows'] ?? '',
            'artworkCountPrice' => $validatedData['artworkCountPrice'] ?? '',
            'displayWindowsPrice' => $validatedData['displayWindowsPrice'] ?? '',
            'displayWindowsPriceYear' => $validatedData['displayWindowsPriceYear'] ?? '',
            'logoAtLocationMonth' => $validatedData['logoAtLocationMonth'] ?? '',
            'logoAtLocation' => $validatedData['logoAtLocation'] ?? '',
            'reserveLogo' => $validatedData['reserveLogo'] ?? '',
            'windowHeadline' => $validatedData['windowHeadline'] ?? '',
            'windowText' => $validatedData['windowText'] ?? '',
            'websiteLink' => $validatedData['websiteLink'] ?? '',
        ];

        Mail::to($validatedData['email'])->send(new AdsMail($details, $attachmentPath));

        return response()->json([
            'message' => 'Ad submission successful',
            'data' => $validatedData,
        ]);
    }
}
