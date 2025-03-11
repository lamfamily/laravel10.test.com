<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Apple Pay Demo</title>
    <style>
    #applePay {
        width: 150px;
        height: 50px;
        display: none;
        border-radius: 5px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        background-image: -webkit-named-image(apple-pay-logo-white);
        background-position: 50% 50%;
        background-color: black;
        background-size: 60%;
        background-repeat: no-repeat;
    }
    </style>
</head>
<body>
    <div>
        <button type="button" id="applePay"></button>
        <p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
        <p style="display:none" id="notgot">ApplePay is not available on this browser</p>
        <p style="display:none" id="success">Test transaction completed, thanks. </p>
    </div>
    <div id="result"></div>

    <script src="https://ap.mpaynow.com/app-fusion/dist/applepay.min.js"></script>
    <script>
    if (window.ApplePaySession) {
        var merchantIdentifier = 'merchant.fusion.mpgs';
        var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
        promise.then(function(canMakePayments) {
            if (canMakePayments) {
                document.getElementById("applePay").style.display = "block";
            } else {
                document.getElementById("got_notactive").style.display = "block";
            }
        });
    } else {
        document.getElementById("notgot").style.display = "block";
    }

    document.getElementById('applePay').addEventListener('click', function() {

        ApplePay.init({
            orderId: <?php echo time();?>,
            validateMerchantURL: 'https://ap.mpaynow.com/apple-mpgs/apple_pay_comm.php?u=',
            paymentAuthorizedURL: 'https://lan-dev-eshop.fusiongogo.com/demo-applepay/process.php',
            payee: 'Jason',
            product: 'iPad',
            currency: 'hkd',
            country: 'hk',
            amount: 0.10,
            domain: 'lan-dev-eshop.fusiongogo.com'
        }).then(function(result) {
            document.getElementById('result').textContent = JSON.stringify(result)
        })

    })
    </script>
</body>
</html>
