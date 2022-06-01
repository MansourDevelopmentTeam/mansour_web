<?php

return [
	"success" => "Success",

	"topPromotions" => "Top Promotions",
	"mostRecent" => "Most Recent",
	"mostBought" => "Most Selling",

	"stateCreated" => "Created",
	"stateProcessing" => "Processing",
	"stateDelivering" => "Delivering",
	"stateCompleted" => "Completed",

	"promoDeactivated" => "Promo code deactivated",
	"promoExpired" => "Promo code expired",
	"promoUsed" => "You Already used this promo code",
	"promoMissing" => "Promo code does not exist",
    "promo_not_valid_for_payment" => "Promo code is not valid for this payment method",

	"checkoutNotes" => "Delivery fees may be changed",

	"linkSent" => "A reset link has been sent to your email",
	"linkSentPhone" => "A code has been sent to your phone",
	"welcomeMessage" => "Thanks for using " . config('app.name') . " 🙂 You can shop all your product needs and enjoy our weekly promotions and offers 🔥",
	"welcomeMessageTitle" => "Welcome to " . config('app.name'),

	"errorIncorrectPassword" => "Password or email are incorrect, kindly check them again.",
	"errorAccountDeactivated" => "Your account is deactivated, please contact the support.",
	"errorNameMin" => "Name must be at least 3 characters",
	"errorEmailUsed" => "This email is already used",
    "noAccess" => "You must Have Access To Use This Page",
    "errorEmailNotFound" => "The email is not registered",
    "errorPhoneNotFound" => "The phone is not registered",
	"errorPhoneUsed" => "This phone number is already used",
	"phone_invalid" => "This phone number is invalid",
	"invalid_phone_length" => "The phone number must be :length digits",
	"errorIncorrectCode" => "Incorrect Code",
	"errorInvalidAddress" => "Please complete all fields",
	"errorPromoNotExist" => "Promo code does not exist",
	"errorPromoExpired" => "Promo code expired",
	"errorPromoDeactivated" => "Promo code deactivated",
	"errorPromoAlreadyUsed" => "You Already used this promo code",
	"errorPromoCartItem" => "Cart does not include products in this promo code.",
	"errorPromoMinimumAmount" => "Order amount doesn't meet the minumum amount for this promo code",
	"errorPromoMinimumAmountWithList" => "This promo for special items and it's amount doesn't meet the minumum amount for this promo code",
	"errorPromoFirstOrderOnly" => "Promo code is only applicable for first orders only",
	"errorNoPhone" => "You must update the app first so we can verify your phone number",
	"errorUpdateApp" => "please verify your phone",
    "errorItemsNotExists" => "There is no items in cart",
    "errorIncorrectVerification" => "Incorrect Verification Code!",
	"errorPhoneVerified" => "Your phone number is already verified",
	"errorMaxProduct" => "Max quantity for ordering :product is :quantity",
	"errorAramexLocation" => "We currently don\'t deliver to this address",
	"errorStoreClosed" => "Thank you for sending your order, we acknowledge that we received it
Please note it takes 72 hours maximum to deliver it.",
	"errorProductNotAvailable" => "Some product is not available",
	"errorIncorrectOldPassword" => "Incorrect password, kindly check them again.",
    "thisPhoneDoesNotHaveAWallet" => "This phone does not have a wallet",

	"payment_discount_not_applied" => "One of your items discount is not applied on your selected payment method",
	"plan_id_required" => "Plan installment is required",
	"linkUsedBefore" => "This link has been expired",
	"file_type_not_allowed" => "please, upload only (image extension allowed)",
	"user_has_invalid_phone" => "Sorry, you should have a valid Mobile Number",
	"phone_verified_successfully" => "Your phone number is verified successfully",
	"errorIncorrectPhone" => "Password or phone are incorrect, kindly check them again.",

    "errorUserHasUnCompletedOrders" => "Order can't be created while others are processing",
    'new_password_sent_via_sms' => 'New password sent via sms'
];
