<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalHttp\HttpClient;

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access credentials context. Use this instance to execute PayPal APIs.
     */
    public static function client(): HttpClient
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal SDK environment with PayPal access credentials.
     */
    private static function environment(): SandboxEnvironment|ProductionEnvironment
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');

        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
