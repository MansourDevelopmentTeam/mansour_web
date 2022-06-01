<?php

return [

        /**
         * https://graph.facebook.com/{API_VERSION}/{PIXEL_ID}/events?access_token={TOKEN}
         * Access token of the pixed app
         * pixel id of the pixel application
         */
        'conversion_api' => [
            'api' => 'https://graph.facebook.com/{API_VERSION}/{PIXEL_ID}/events?access_token={TOKEN}',
            'api_version' => envFromDB('FACEBOOK_CONVERSION_API_VERSION') ?? null,
            'access_token' => envFromDB('FACEBOOK_CONVERSION_ACCESS_TOKEN') ?? null,
            'pixel_id' => envFromDB('FACEBOOK_CONVERSION_PIXEL_ID') ?? null
        ]
];
