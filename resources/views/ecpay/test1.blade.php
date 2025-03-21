<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="zh-TW">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="description" content="綠界科技 ECPay 提供信用卡刷卡、超商代收及取貨付款、ATM轉帳...等多種金流收款服務，會員可於綠界網站建立收款網址或使用API程式串接，應用彈性，收款隔日起即撥款。支付找綠界，買賣無國界。"><!-- 必填，限制 81-150 字 -->
    <meta name="keywords" content="信用卡,ATM轉帳,超商代碼,超商條碼,applepay,googlepay,samsungpay,金流服務">
    <title>綠界科技 ECPay - 第三方支付領導品牌</title>

</head>

<body>
    <div class="order-info">
        <div id="ECPayPayment">result:</div><br />

        <form action="" id="PayProcess" method="post">
            <div style="text-align: center;">

                <input id="PaymentType" name="PaymentType" type="hidden" value="" />
                <input id="btnPay" type="button" class="btn single btn-gray-dark" value="確認付款" />
            </div>
            <br />
            <div style="text-align: center;">
                消費者選擇付款方式取得的PayToken : <input id="PayToken" name="PayToken" type="Text" size="50" value="" />
            </div>
        </form>
    </div>
</body>

</html>
<!-- 綠界科技 ECPay SDK 需引用JS 區塊 -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
<script src="https://ecpg-stage.ecpay.com.tw/Scripts/sdk-1.0.0.js?t=20210121100116"></script>

<script type="text/javascript">
    $(function() {
        var env = "{{$env}}";
        var token = "{{$token}}"; //請設定你取到的廠商驗證碼
        var is_show_loading = 1;
        var lang = ECPay.Language.zhTW;

        //初始化SDK畫面
        ECPay.initialize(env, is_show_loading, function(errMsg) {
            try {
                ECPay.createPayment(token, lang, function(errMsg) {
                    if (errMsg != null) {
                        ErrHandle(errMsg);
                    }
                }, 'V2');
                $('#Language').val(lang);
            } catch (err) {
                ErrHandle(err);
            }
        });

        // 消費者選擇完成付款方式,取得PayToken
        $('#btnPay').click(function() {

            try {
                ECPay.getPayToken(function(paymentInfo, errMsg) {
                    if (errMsg != null) {
                        ErrHandle(errMsg);
                        return;
                    };
                    $("#PayToken").val(paymentInfo.PayToken);

                    return true;
                });
            } catch (err) {
                ErrHandle(err);
            }

            return false;
        });
    });

    function ErrHandle(err) {
        if (err != null) {
            $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">' + err + '</label></div>');
            console.log(err);
        } else {
            $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">Token取得失敗</label></div>');
            console.log('Wrong');
        }
    }
</script>
