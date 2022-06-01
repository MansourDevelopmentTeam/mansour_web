<html>

<head>

    <script src="{{ $checkoutJs }}" data-error="errorCallback" data-cancel="cancelCallback"
        data-complete="{{URL::to('api/customer/orders/receipt/'.$transaction->id.'?token=' . $token)}}">
    </script>

    <script type="text/javascript">
            function errorCallback(error) {
                window.location = '{!!config('app.website_url') . "/checkout/final-receipt?is_success=false&message=Error payment"!!}';
            }
           
            function cancelCallback() {
                window.location = '{!!config('app.website_url') . "/checkout/final-receipt?is_success=false"!!}';
            }
       
       
			Checkout.configure({
                merchant: "{{$merchantId}}",
                order: {
                amount: "{{ $transaction->total_amount }}",
                    currency: "{{($order_currency)}}",
                    description: 'Customer Id #{{$customerId}}',
                    id: "{{ $transaction->id }}",
                },
                interaction: {
                    merchant: {
                        name: 'Online Payment',
                        logo: "{{ config('app.colored_logo_en') }}"
                    },
                    displayControl: {
                        billingAddress: 'HIDE',
                        customerEmail: 'HIDE',
                        orderSummary: 'HIDE',
                        shipping: 'HIDE'
                    },
                },
                session: {
                    id: "{{ $session_id }}"
                }
            });
            // Checkout.showPaymentPage();
            Checkout.showLightbox();
    </script>

</head>

<body>

</body>

</html>