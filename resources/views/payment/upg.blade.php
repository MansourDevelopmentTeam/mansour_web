<HTML>

<script src="https://upgstaging.egyptianbanks.com:3006/js/Lightbox.js"></script>
<script type="text/javascript">
    function callLightbox() {
        var orderId = '';
        var paymentMethodFromLightBox = null;
        var amount = {{$amount}};
        var mID = {{$mID}};
        var tID = {{$tID}};
        var mRN = {{$order_id}};
        var secureHash = "{{$secureHash}}";
        var trxDateTime = {{$trxDateTime}};
        var returnUrl = "{{$returnUrl}}";

        Lightbox.Checkout.configure = {
            OrderId: orderId,
            paymentMethodFromLightBox: paymentMethodFromLightBox,
            MID: mID,
            TID: tID,
            SecureHash : secureHash,
            TrxDateTime : trxDateTime,
            Currency : 'EGP',
            AmountTrxn: amount,
            MerchantReference: mRN,
            ReturnUrl:returnUrl,
            completeCallback: function (data) {
                //your code here
            },
            errorCallback: function () {
                //your code here
            },
            cancelCallback:function () {
                //your code here
            }
        };
        Lightbox.Checkout.showPaymentPage();
    }

    callLightbox();
</script>
</HTML>
