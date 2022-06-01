@php
    $customerData = $transaction->customer;
    $totalAmount = $transaction->total_amount;
@endphp
<script type="text/javascript" src="https://www.simplify.com/commerce/simplify.pay.js"></script>
<iframe name="El-dokan"
        width="100%"
        height="100%"
        data-sc-key="{{$public_key}}"
        data-reference="{{$transaction->id}}"
        data-amount="{{$transaction->total_amount}}"
        data-currency="QAR"
        data-customer-email="{{$customerData ? $customerData->email : null}}"
        data-customer-name="{{$customerData ? $customerData->name : null}}"
        data-color="#CCA809"
        data-address-country="EG"
        data-redirect-url="{{$call_back_url}}"/>
