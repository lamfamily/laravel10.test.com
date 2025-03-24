<?php
$date = time();
$sr = 'https://ecpg-stage.ecpay.com.tw/Scripts/sdk-1.0.0.js?t=' . $date;
$token = $_POST["Token"]; //交易代碼回傳的Token
$MerchantTradeNo = $_POST["MerchantTradeNo"];
$servertype = "stage";
$isloading = 1;
?>

<body bgcolor="orange">
    <div>
        <div class="oi-lan-box">
            <div class="oi-lan" style="text-align: right;">
                <!--語系:可有可無，若無指定預設為繁體中文-->
                <select id="Language">
                    <option value="zh-TW">繁體中文</option>
                    <option value="en-US">English</option>
                </select>
            </div>
        </div>
        <div>
            <div id="main">
                <div id="main1">
                    <div id="ECPayPayment"></div>
                </div>
                <div style="text-align: center;"><label style="color: red;">選擇付款方式前請勿按下"確認付款"按鈕</label></div>
                <div style="text-align: center;">
                    <input id="btnPay" type="button" value="確認付款" />
                </div>
            </div>
        </div>
    </div>

    <!-- JS順序請如下 -->

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
    <script src="<?php echo $sr ?>"></script>

    <script type="text/javascript">
        $(function() {
            ECPay.initialize('<?php echo $servertype ?>', '<?php echo $isloading ?>', function(errMsg) {
                var _token = '<?php echo $token ?>'
                if (_token === '') {
                    alert("token取得失敗");
                }

                try {
                    /*建立相關UI*/
                    ECPay.createPayment(_token, ECPay.Language.zhTW, function(errMsg) {
                        //console.log('Callback Message: ' + errMsg);
                        if (errMsg != null)
                            ErrHandle(errMsg);
                    });
                    $('#Language').val(ECPay.Language.zhTW);
                } catch (e) {
                    ErrHandle(null);
                }

            });

            $('#Language').on('change', function() {
                try {
                    ECPay.createPayment('<?php echo $token ?>', $('#Language').val(), function(errMsg) {
                        //console.log('Callback Message: ' + errMsg);
                        if (errMsg != null)
                            ErrHandle(errMsg);
                    });
                } catch (e) {
                    ErrHandle(null);
                }
            });

            $('#btnPay').click(function() {
                try {
                    ECPay.getPayToken(function(paymentInfo, errMsg) {
                        //console.log("response => getPayToken(paymentInfo, errMsg):", paymentInfo, errMsg);
                        if (errMsg != null) {
                            ErrHandle(errMsg);
                            return;
                        };
                        var PayToken = paymentInfo.PayToken;
                        var MerchantTradeNo = '<?php echo $MerchantTradeNo ?>'
                        var url = 'CreatePaymentByWeb.php';
                        standardPost(url, PayToken, MerchantTradeNo);
                        return true;
                    });

                } catch (e) {
                    ErrHandle(null);
                }
                return false;
            });

        });

        function getApplePayResultData(resultData, errMsg) {
            alert(JSON.stringify(resultData));
        }

        function standardPost(url, args, MerchantTradeNo) {
            var form = $("<form method='post'></form>");
            form.attr({
                "action": url
            });

            var input = $("<input type='hidden'>");
            input.attr({
                "name": "PayToken"
            });
            input.val(args);
            var input1 = $("<input type='hidden'>");
            input1.attr({
                "name": "MerchantTradeNo"
            });
            input1.val(MerchantTradeNo);
            form.append(input, input1);

            $("html").append(form);
            form.submit();
        }

        function ErrHandle(strErr) {

            if (strErr != null) {
                $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">' + strErr + '</label></div>');
            } else {
                $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">Token取得失敗</label></div>');
            }

            //$('#btnPay').hide();
        }
    </script>
