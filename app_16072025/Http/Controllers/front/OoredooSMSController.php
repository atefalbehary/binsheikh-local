<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Reviews;

class OoredooSMSController extends Controller
{
    private $apiUrl;
    private $username;
    private $password;

    public function __construct()
    {
        // Load credentials from Laravel .env file
        $this->apiUrl = config('services.ooredoo.api_url', 'https://messaging.ooredoo.qa/bms/api/Sms');
        $this->username = config('services.ooredoo.username');
        $this->password = config('services.ooredoo.password');
    }

    /**
     * Send SMS via Ooredoo API
     *
     * @param  string  $to
     * @param  string  $text
     * @param  string  $from
     * @param  string|null  $deferred
     * @param  array  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSMS($to, $text, $from = null, $deferred = null, $options = [])
    {
        try {
            $data = [
                'from' => $from ?? config('services.ooredoo.default_sender', 'Fromashop'),
                'to' => $to,
                'type' => 0,
                'text' => $text,
                'deferred' => $deferred,
                'blink' => $options['blink'] ?? false,
                'flash' => $options['flash'] ?? false,
                'private' => $options['private'] ?? false
            ];

            $data = array_filter($data, function($value) {
                return $value !== null;
            });

            $response = $this->makeApiRequest($data);

            if ($response['status_code'] >= 200 && $response['status_code'] < 300) {
                Log::info('SMS sent successfully', ['response' => $response]);
                return response()->json($response);
            } else {
                Log::error('SMS sending failed', ['response' => $response]);
                return response()->json($response, $response['status_code']);
            }

        } catch (Exception $e) {
            Log::error('SMS API Error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Make the API request
     *
     * @param  array  $data
     * @return array
     * @throws Exception
     */
    private function makeApiRequest(array $data)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password)
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        return [
            'status_code' => $httpCode,
            'response' => json_decode($response, true) ?: $response
        ];
    }
}
