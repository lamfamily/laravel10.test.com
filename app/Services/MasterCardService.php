<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MasterCardService
{

    /*
     * build mastercard request headers for Http facade
     * @author: Justin Lin
     * @date : 2025-02-19 16:25:53
     */
    public static function buildHeaders()
    {
        $tmp_str = 'merchant.' . config('mastercard.GATEWAY_MERCHANT_ID') . ':' . config('mastercard.GATEWAY_API_PASSWORD');

        $auth_str = base64_encode($tmp_str);

        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $auth_str,
        ];
    }


    /*
     * create mastercard session
     * @author: Justin Lin
     * @date : 2025-02-19 16:26:16
     */
    public static function createSession($data)
    {
        $url = config('mastercard.GATEWAY_BASE_URL') . 'version/' . config('mastercard.GATEWAY_API_VERSION') . '/merchant/' . config('mastercard.GATEWAY_MERCHANT_ID') . '/session';

        try {
            $response = Http::withoutVerifying()->withHeaders(self::buildHeaders())->post($url, $data);

            if ($response->successful()) {

                Log::channel('mastercard')->info('HTTP Request Success: ');
                Log::channel('mastercard')->info('request data', [$url, $data]);
                Log::channel('mastercard')->info('response data', $response->json());

                return $response->json();
            } else {
                Log::channel('mastercard')->error('HTTP Request Error: ' . $response->body());

                return [
                    'error' => true,
                    'message' => $response->body(),
                ];
            }
        } catch (\Exception $e) {

            Log::channel('mastercard')->error('HTTP Request Error: ' . $e->getMessage());

            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
