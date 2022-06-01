<html>
    <head>
        <script src="https://qnbalahli.test.gateway.mastercard.com/checkout/version/47/checkout.js"
            data-error="errorCallback"
            data-cancel="cancelCallback">
            </script>
        
<script type="text/javascript">
function errorCallback(error) {
    console.log(JSON.stringify(error));
}
function cancelCallback() {
    console.log('Payment cancelled');
}
        
Checkout.configure({
    merchant: 'TESTQNBAATEST001',
    order: {
        amount: function () {
            //Dynamic calculation of amount
            return 1;
        },
        currency: 'EGP',
        description: 'TestOrder2018061mnn1',
        id: 'T1jkdddsddfddfsljl'
    },
    billing: {
        address: {
            street: '123 Customer Street',
            city: 'Metropolis',
            postcodeZip: '99999',
            stateProvince: 'NY',
            country: 'USA'
        }
    },
    interaction: {
        merchant: {
            name: 'Your merchant name',
            address: {
                line1: '200 Sample St',
                line2: '1234 Example Town'
            },
            email: 'order@yourMerchantEmailAddress.com',
            phone: '+1 123 456 789 012',
            logo: 'https://imageURL'
        },
        locale: 'ar_eg',
        theme: 'default',
        displayControl: {
            billingAddress: 'HIDE',
            customerEmail: 'HIDE',
            orderSummary: 'HIDE',
            shipping: 'HIDE'
        }
    }
});
Checkout.showLightbox();
</script>
    </head>
 
</html>
