<?php

namespace App\Services\Facebook;

use Illuminate\Support\Facades\Log;

class ConversionAPI
{
   private $conversionAPI;

   private $version;
   
   private $accessToken;
   
   private $pixelId;

   public function __construct(array $config)
   {
      $this->conversionAPI = $config['api'];
      $this->version = $config['api_version'];
      $this->accessToken = $config['access_token'];
      $this->pixelId = $config['pixel_id'];
   }

   public function send($order)
   {
      $this->conversionAPI = str_replace('{API_VERSION}', $this->version, $this->conversionAPI);
      $this->conversionAPI = str_replace('{PIXEL_ID}', $this->pixelId, $this->conversionAPI);
      $this->conversionAPI = str_replace('{TOKEN}', $this->accessToken, $this->conversionAPI);
      $data = $this->mapOrder($order);
      $params = [
         'data' => json_encode($data)
      ];
      
      $ch = curl_init();
      
      $defaults = [
         CURLOPT_URL => $this->conversionAPI,
         CURLOPT_POST => true,
         CURLOPT_POSTFIELDS => http_build_query($params),
         CURLOPT_RETURNTRANSFER => true
      ];

      curl_setopt_array($ch, $defaults);
      
      $response = curl_exec($ch);
      Log::info('Conversion API response : ' . $response);
      curl_close($ch);
      return $response;
   }

   private function mapOrder($order)
   {
      $contents = [];

      foreach($order->items as $item) {
         $contents[] = [
            'id' => $item->product_id,
            'quantity' => $item->amount
         ];
      }
      $data[] = [
         'event_name' => 'Purchase',
         'event_time' => time(),
         'user_data' => [
            'em' => hash('sha256', $order->customer->email),
            'client_user_agent' => $order->user_agent
         ],
         'contents' => $contents,
         'custom_data' => [
            'content_type' => 'product',
            'currency' => 'EGP',
            'value' => $order->getTotal()
         ],
         'action_source' => 'website'
      ];
      return $data;
   }
}