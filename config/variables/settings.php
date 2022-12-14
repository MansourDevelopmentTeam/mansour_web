<?php

return [
    [
        "label"       => "Ex Rate Pts",
        "key"         => "ex_rate_pts",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "X points added to User account for Each Rate Egp ",
    ],
    [
        "label"       => "Ex Rate Egp",
        "key"         => "ex_rate_egp",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "Y EGP spent by the user",
    ],
    [
        "label"       => "Ex Rate Gold",
        "key"         => "ex_rate_gold",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "Extra % of points the user will get while Gold",
    ],
    [
        "label"       => "EGP Gold",
        "key"         => "egp_gold",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "Egp need per month to earn user gold status",
    ],
    [
        "label"       => "Pending Days",
        "key"         => "pending_days",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "The number of days the user points will remain 'Pending' before it changes to 'Earned'",
    ],
    [
        "label"       => "Refer Points",
        "key"         => "refer_points",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "Number of points the users get when they refer a friend . ",
    ],
    [
        "label"       => "Refer Minimum",
        "key"         => "refer_minimum",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => "The minimum order amount for the referal code to work",
    ],
    [
        "label"       => "Off Time",
        "key"         => "off_time",
        "type"        => "time",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "Min Order Amount",
        "key"         => "min_order_amount",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 0,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "Open Time",
        "key"         => "open_time",
        "type"        => "time",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "Except Cod Amount",
        "key"         => "except_cod_amount",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "Menu",
        "key"         => "menu",
        "type"        => "textarea",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 0,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "key"         => "DELIVERY_FEES",
        "label"       => "DELIVERY_FEES",
        "type"        => "single_select",
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "scope"       => "backend",
        "options"     => '[{"aramex" : "Aramex"},{"location" : "Location"}]',
        "description" => "DELIVERY_FEES",
    ],
    [
        "label"       => "Affiliate Pending Days",
        "key"         => "affiliate_pending_days",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "key"         => "enable_affiliate",
        "label"       => "Enable Affiliate",
        "group"       => "Ecommerce",
        "scope"       => "global",
        "type"        => "switch",
    ],
    [
        "label"       => "Enable Prescription",
        "key"         => "enable_prescription",
        "type"        => "switch",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Enable Guest Checkout",
        "key"         => "enable_guest_checkout",
        "type"        => "switch",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "customer",
        "description" => null,
    ],
    [
        "label"       => "Country Code",
        "key"         => "COUNTRY_CODE",
        "type"        => "single_select",
        "options"     => '[{"EG" : "Egypt"},{"QA" : "Qatar"}]',
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "customer",
        "description" => null,
    ],
    [
        "label"       => "Currency Label (EN)",
        "key"         => "CURRENCY_CODE_EN",
        "type"        => "single_select",
        "options"     => '[{"LE" : "LE"},{"QR" : "QR"}]',
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Currency Label (AR)",
        "key"         => "CURRENCY_CODE_AR",
        "type"        => "single_select",
        "options"     => '[{"??.??" : "??.??"},{"??.??" : "??.??"}]',
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Ordering Notifiers List",
        "key"         => "ORDER_NOTIFIER_EMAILS",
        "type"        => "text",
        "group"       => "Ecommerce",
        "required"    => false,
        "editable"    => true,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "Enable Districts",
        "key"         => "ENABLE_DISTRICT",
        "type"        => "switch",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Facebook Conversion Api Version",
        "key"         => "FACEBOOK_CONVERSION_API_VERSION",
        "type"        => "text",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Facebook Conversion Access Token",
        "key"         => "FACEBOOK_CONVERSION_ACCESS_TOKEN",
        "type"        => "text",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Facebook Conversion Pixel Id",
        "key"         => "FACEBOOK_CONVERSION_PIXEL_ID",
        "type"        => "text",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 1,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => null,
    ],
    [
        "label"       => "Payment Targets",
        "key"         => "PAYMENT_TARGETS",
        "type"        => "float",
        "options"     => null,
        "group"       => "Ecommerce",
        "required"    => 0,
        "editable"    => 1,
        "order"       => 999,
        "scope"       => "global",
        "description" => "Total payment purchase targets",
    ],
    [
        "label"       => "ORANGE SEND ID",
        "key"         => "ORANGE_SENDER_ID",
        "type"        => "text",
        "group"       => "Ecommerce",
        "required"    => false,
        "editable"    => true,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "ORANGE SMS USERNAME",
        "key"         => "ORANGE_SMS_USERNAME",
        "type"        => "text",
        "group"       => "Ecommerce",
        "required"    => false,
        "editable"    => true,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
    [
        "label"       => "ORANGE SMS PASSWORD",
        "key"         => "ORANGE_SMS_PASSWORD",
        "type"        => "text",
        "group"       => "Ecommerce",
        "required"    => false,
        "editable"    => true,
        "order"       => 999,
        "scope"       => "backend",
        "description" => null,
    ],
];
