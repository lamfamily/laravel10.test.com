<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ap-gateway.mastercard.com/static/checkout/checkout.min.js" data-error="errorCallback" data-cancel="cancelCallback"></script>
</head>

<body>
    <h1>
        CHECKOUT PAGE
    </h1>

    <div id="embed-target"> </div>
    <input type="button" value="Pay with Embedded Page" onclick="Checkout.showEmbeddedPage('#embed-target');" />
    <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />

</body>

<script>
    function errorCallback(error) {
        console.log(JSON.stringify(error));
    }

    function cancelCallback() {
        console.log('Payment cancelled');
    }

    const session_id = "{{ $session_id }}"
    Checkout.configure({
        session: {
            id: session_id
        }
    });
</script>

</html>
