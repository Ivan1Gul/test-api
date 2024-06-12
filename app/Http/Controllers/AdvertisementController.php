<?php

namespace App\Http\Controllers;

use App\Mail\AdsMail;
use PayPalHttp\HttpException;
use App\Services\PayPalClient;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateAdsRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class AdvertisementController extends Controller
{
    public function create(CreateAdsRequest $request)
    {
        $validatedData = $request->validated();

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
            'displayWindows' => $validatedData['displayWindows'] ?? 0,
            'artworkCountPrice' => $validatedData['artworkCountPrice'] ?? 0,
            'displayWindowsPrice' => $validatedData['displayWindowsPrice'] ?? 0,
            'displayWindowsPriceYear' => $validatedData['displayWindowsPriceYear'] ?? 0,
            'logoAtLocationMonth' => $validatedData['logoAtLocationMonth'] ?? 0,
            'logoAtLocation' => filter_var($request['logoAtLocation'], FILTER_VALIDATE_BOOLEAN) ?? false,
            'reserveLogo' => $validatedData['reserveLogo'] ?? '',
            'windowHeadline' => $validatedData['windowHeadline'] ?? '',
            'windowText' => $validatedData['windowText'] ?? '',
            'websiteLink' => $validatedData['websiteLink'] ?? '',
        ];

        Mail::to($validatedData['email'])->send(new AdsMail($details, $attachmentPath));
        if (
            (
                empty($details['displayWindows']) || $details['displayWindows'] === 0
            ) &&
            (
                empty($details['artworkCountPrice']) || $details['artworkCountPrice'] === 0
            ) &&
            (
                empty($details['displayWindowsPrice']) || $details['displayWindowsPrice'] === 0
            ) &&
            (
                empty($details['displayWindowsPriceYear']) || $details['displayWindowsPriceYear'] === 0
            ) &&
            (
                empty($details['logoAtLocationMonth']) || $details['logoAtLocationMonth'] === 0
            )
        ) {
            return response()->json([
                'message' => 'Thank you for your participation!',
                'data' => $details,
            ]);
        }

        $items = [];
        $totalAmount = 0;

        if ($details["displayWindows"] !== 0) {
            $items[] = [
                'name' => 'Display windows',
                'description' => 'Display windows (£30 each)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => '30'],
                'quantity' => $details["displayWindows"]
            ];
            $totalAmount += 30 * $details["displayWindows"];
        }

        if ($details["artworkCountPrice"] !== 0) {
            if ($details["artworkCountPrice"] == 1) {
                $price = 0;
            } else {
                $price = 20;
            }
            $items[] = [
                'name' => 'Display window artworks',
                'description' => 'Display window artworks (£20 each)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => $price],
                'quantity' => $details["artworkCountPrice"]
            ];
            $totalAmount += $price * $details["artworkCountPrice"];
        }

        if ($details["displayWindowsPrice"] !== 0) {
            $items[] = [
                'name' => 'Display window',
                'description' => 'Display window (£10 per month)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => '10'],
                'quantity' => $details["displayWindowsPrice"]
            ];
            $totalAmount += 10 * $details["displayWindowsPrice"];
        }

        if ($details["displayWindowsPriceYear"] !== 0) {
            $items[] = [
                'name' => 'Display window/s',
                'description' => 'Display window/s (£55 each per year)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => '55'],
                'quantity' => $details["displayWindowsPriceYear"]
            ];
            $totalAmount += 55 * $details["displayWindowsPriceYear"];
        }

        if ($details["logoAtLocationMonth"] !== 0) {
            $items[] = [
                'name' => 'Months of Logo display',
                'description' => 'Months of Logo display (£10 per month)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => '10'],
                'quantity' => $details["logoAtLocationMonth"]
            ];
            $totalAmount += 10 * $details["logoAtLocationMonth"];
        }

        if ($details["logoAtLocation"] === 'true') {
            $items[] = [
                'name' => 'Logo on home page',
                'description' => 'Logo on home page (£80 per year)',
                'unit_amount' => ['currency_code' => 'GBP', 'value' => '80'],
                'quantity' => 1
            ];
            $totalAmount += 80;
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "GBP",
                    "value" => $totalAmount,
                    "breakdown" => [
                        "item_total" => ["currency_code" => "GBP", "value" => $totalAmount]
                    ]
                ],
                "items" => $items
            ]],
            "application_context" => [
                "return_url" => 'http://citymapsapi/api/advertisement',
                "cancel_url" => 'http://citymapsapi/api/advertisement'
            ]
        ];

        try {
            $response = PayPalClient::client()->execute($request);

            $approvalUrl = null;
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    $approvalUrl = $link->href;
                    break;
                }
            }

            return response()->json(['approval_url' => $approvalUrl]);
        } catch (HttpException $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
