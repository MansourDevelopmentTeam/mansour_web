<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetabaseController extends Controller
{
    public function index()
    {
        $iframeUrl =  config('app.metabase_url') . $this->createJwtToken() . "#bordered=true&titled=true";
        // $iframeUrl = "https://metabase..com/public/dashboard/fa4979d5-263c-4610-ba6a-8dfbcae958dd";
        return $this->jsonResponse("Success", ["iframeUrl" => $iframeUrl]);
    }

    private function createJwtToken()
    {
        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Create token payload as a JSON string
        $payload = json_encode([
            'resource' => [
                "dashboard" => 2
            ],
            'params' => new \stdCLass,
            "exp" => floor((time()) + (10*60))
        ]);
        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, config('app.metabase_token'), true);
        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }
}
