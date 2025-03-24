<?php
//介接資訊
$oService = new NetworkService();	// // 初始化網路服務物件。
$oService->ServiceURL = 'https://ecpg-stage.ecpay.com.tw/Merchant/GetTokenbyTrade';
$szHashKey = 'pwFHCqoQZGmho4w6';
$szHashIV = 'EkRm7iFT261dpevs';

/*************************************POST參數設置************************************************************/
$szPlatformID = '';
$szMerchantID = '3002607';
$szATMInfo = '';
$szCVSInfo = '';
$szBarcodeInfo = '';


/*************************************產生GUID****************************************************************/
function guid(){
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $uuid = substr($charid, 0, 8)
        .substr($charid, 8, 4)
        .substr($charid,12, 4)
        .substr($charid,16, 4)
        .substr($charid,20,12);
    return $uuid;
}

/*************************************判斷Json****************************************************************/
function isJson($data = '', $assoc = false) {
    $data = json_decode($data, $assoc);
    if ($data && (is_object($data)) || (is_array($data) && !empty($data))) {
        return $data;
    }
    return false;
}

/*************************************要傳遞的 Data 參數******************************************************/
$szData = '';
$arData = array();
$szOrderInfo = '';
$arOrderInfo = array();
$szCardInfo = '';
$arCardInfo = array();
$szATMInfo = '';
$arATMInfo = array();
$szCVSInfo = '';
$arCVSInfo = array();
$szBarcodeInfo = '';
$arBarcodeInfo = array();
$szConsumerInfo = '';
$arConsumerInfo = array();
$arParameters = array();
$arFeedback = array();
$Timestamp=time();
$szRqHeader=array();
$RqID= guid();
$Revision='1.0.0';
$MerchantTradeNo=date('YmdHis');

date_default_timezone_set("Asia/Taipei");

$szRqHeader=array(
'Timestamp' => $Timestamp,
'Revision' => $Revision,
);

$arOrderInfo = array(

    //交易時間
	'MerchantTradeDate' => date('Y/m/d H:i:s'),
    
	//交易編號
	'MerchantTradeNo' => $MerchantTradeNo,
	//交易金額
	'TotalAmount' => '2000',
	
	//付款回傳結果
	'ReturnURL' => 'http://4790-211-23-76-78.ngrok-free.app',
	
	//交易描述
	'TradeDesc' => 'Airinum Urban Air Filter 2.0 - 3 Pack - L 濾芯 (三片裝)*1',

	//商品名稱
	'ItemName' => 'Airinum Urban Air Filter 2.0 - 3 Pack - L 濾芯 (三片裝)',
	
	
);

$arCardInfo = array(
    
	
	//使用信用卡紅利
	'Redeem' => '0',
	
	//刷卡分期期數
	'CreditInstallment' => '3,6,12',
	
	//定期定額每次授權金額
	'PeriodAmount' => '100',
	
	//定期定額週期種類
	'PeriodType' => 'M',
	
	//執行頻率
	'Frequency' => '12',
	
	//執行次數
	'ExecTimes' => '99',
	
	//定期定額的執行結果回應URL
	'PeriodReturnURL' => 'http://5c78-211-23-76-78.ngrok.io/php/Embedded/Auto/simple_ServerReplyPaymentStatus3.php',
	
	//3D授權回傳網址
	'OrderResultURL' => 'http://4790-211-23-76-78.ngrok-free.app/checkoutSuccess?payWay=1',

    //圓夢彈性分期期
	'FlexibleInstallment' => '30',	
);


$arATMInfo = array(
    
	//允許繳費有效天數
	'ExpireDate' => '1',
	'ATMBankCode' =>'118',
		
	
);

$arCVSInfo = array(
    
	//超商繳費截止時間
	'StoreExpireDate' => 7,
	'CVSCode' => 'FAMILY',
	'Desc_1' => '',
	'Desc_2' => '',
	'Desc_3' => '',
	'Desc_4' => '',
		
	
);

$arBarcodeInfo = array(
    
	//超商繳費截止時間
	'StoreExpireDate' => '10',
		
);
$arUnionPayInfo = array(
    
	'OrderResultURL' => 'http://4790-211-23-76-78.ngrok-free.app/checkoutSuccess?payWay=1',
		
);

$arConsumerInfo = array(
    
	//消費者會員編號
	'MerchantMemberID' => 'test1255434',
	
	//電子信箱
	'Email' => 'techsupport@ecpay.com.tw',
	
	//電話
	'Phone' => '0933999999',
	
	//姓名
	'Name' => 'Jame',
	
	//國別碼
	'CountryCode' => '158',
	
	//地址
	'Address' =>'testrrrr',
	
);

$arData = array(
    
	//特約合作平台商代號
	//'PlatformID' => '',
    
	//會員編號
	'MerchantID' => $szMerchantID,
	
	//是否使用記憶卡號功能
	'RememberCard' => '1',
	
	//畫面的呈現方式
	'PaymentUIType' => '2',
	
	//付款方式
	'ChoosePaymentList' => '0',
	
	//交易資訊
	'OrderInfo' => $arOrderInfo,
	
	//ATM資訊
	'ATMInfo' => $arATMInfo,
	
	//超商代碼資訊
	'CVSInfo' => $arCVSInfo,
	
	//超商條碼資訊
	'BarcodeInfo' => $arBarcodeInfo,

	//信用卡資訊
	'CardInfo' => $arCardInfo,
	
	'UnionPayInfo'=>$arUnionPayInfo,
	
	//消費者資訊
	'ConsumerInfo' => $arConsumerInfo,
	
	//特店自訂欄位
	'CustomField' => '"designer":"icoderexpert","database":"MemberDB","solution":"mem"',
	
);
/******************************************************************************************************************************************/

//轉Json格式
$szData = json_encode($arData);

//做urlencode
$szData = urlencode($szData);
	
//AES
$oCrypter = new AESCrypter($szHashKey, $szHashIV);
	
// 加密 Data 參數內容
$szData = $oCrypter->Encrypt($szData);

//要POST的參數
$arParameters = array(
	'MerchantID' => $szMerchantID,
	'RqHeader' => $szRqHeader,
	'Data' => $szData
);

//轉Json格式
$arParameters = json_encode($arParameters);
echo "印出Data參數<br>";
echo $szData,"<br>","<br>";
echo "印出Data加密結果<br>";
echo $szData,"<br>","<br>";
echo "印出POST參數<br>";
echo $arParameters,"<br>","<br>";
// 傳遞參數至遠端。
$szResult = $oService->ServerPost($arParameters);
echo $arParameters,"<br>","<br>";
echo "印出回傳結果<br>";
echo $szResult,"<br>";
//判斷回傳是否為Json格式
$ResultisJson=isJson($szResult);

if($ResultisJson==TRUE){

    $DataisNull=json_decode($szResult,true);

    if(isset($DataisNull["Data"])){

        if($DataisNull["Data"]!==''){

            $DataDec = $oCrypter->Decrypt($DataisNull["Data"]);
			$DataDec1=json_decode($DataDec,true);
			$Token=$DataDec1["Token"];
			echo"Data內容<br>";
			echo $DataDec,"<br>";
			echo "訂單編號:<br>";
			echo $MerchantTradeNo,"<br>";
			if($DataDec1["Token"]!==''){
			echo "TOKEN:<br>";
			echo $Token;
			$gateway_url='./SDK.php';
			        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .=     '<head>';
        $szHtml .=         '<meta charset="utf-8">';
        $szHtml .=     '</head>';
        $szHtml .=     '<body>';
        $szHtml .=         "<form id=\"__ecpayForm\" method=\"post\" target=\"_self\" action=\"{$gateway_url}\">";  
        $szHtml .=         "<input type=\"hidden\" name=\"Token\" value=\"". htmlentities($Token) . "\" />";
		$szHtml .=         "<input type=\"hidden\" name=\"MerchantTradeNo\" value=\"". htmlentities($MerchantTradeNo) . "\" />";
        $szHtml .=         '<script type="text/javascript">document.getElementById("__ecpayForm").submit();</script>';
        $szHtml .=     '</body>';
        $szHtml .= '</html>';


			echo $szHtml;
			}
        }
        else{
            echo"Data回傳空值<br>";
        }
    }
    else{
        echo"回傳沒有Data<br>";
    }
}
else {
	echo "回傳格錯誤，非Json格式<br>";
}

/************************************服務類別*************************************************/

/**
 * 呼叫網路服務的類別。
 */
class NetworkService {

    /**
     * 網路服務類別呼叫的位址。
     */
    public $ServiceURL = 'ServiceURL';

    /**
     * 網路服務類別的建構式。
     */
    function __construct() {
        $this->NetworkService();
    }
    
    /**
     * 網路服務類別的實體。
     */
    function NetworkService() {

    }

    /**
     * 提供伺服器端呼叫遠端伺服器 Web API 的方法。
     */
    function ServerPost($parameters) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->ServiceURL);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($parameters)));
        $rs = curl_exec($ch);

        curl_close($ch);

        return $rs;
		
    }
	
}

/**
 * AES 加解密服務的類別。
 */
class AesCrypter {

    private $Key = 'pwFHCqoQZGmho4w6';
    private $IV = 'EkRm7iFT261dpevs';
    //private $Key = 'y6869NBszTuvhSRx';
    //private $IV = 'BMm7FmX91dE8rpdw';

    /**
     * AES 加解密服務類別的建構式。
     */
    function __construct($key, $iv) {
        $this->AesCrypter($key, $iv);
    }

    /**
     * AES 加解密服務類別的實體。
     */
    function AesCrypter($key, $iv) {
        $this->Key = $key;
        $this->IV = $iv;
    }

    /**
     * 加密服務的方法。
     */
    function Encrypt($data)
    {
		$szData = openssl_encrypt($data, 'AES-128-CBC', $this->Key, OPENSSL_RAW_DATA, $this->IV);
        $szData = base64_encode($szData);

        return $szData;
    }
	
    /**
     * 解密服務的方法。
     */
	function Decrypt($data)
    {
		$szValue = openssl_decrypt(base64_decode($data), 'AES-128-CBC', $this->Key, OPENSSL_RAW_DATA, $this->IV);
		$szValue=urldecode($szValue);
        return $szValue;
    }
}

/**
 * 網頁跳轉的類別。
 */
class ToURL {
	
	/**
     * 網頁跳轉類別的建構式。
     */
	function __construct() {
        $this->ToURL();
    }
	
	 
    /**
     * 網頁跳轉類別的實體。
     */
    function ToURL() {

    }
    /**
     * 跳轉至3D頁面的方法。
     */
    function To3DURL($data) {
        echo " <script   language = 'javascript'  
		type = 'text/javascript'> ";  
		echo " window.location.href = '$data' ";  
		echo " </script > ";  
	}
}
?>