<?php
//介接資訊
$oService = new NetworkService();	// // 初始化網路服務物件。
$oService->ServiceURL = 'https://ecpg-stage.ecpay.com.tw/Merchant/CreatePayment';
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
$Revision='1.0.0';
$PayToken=($_POST['PayToken']);
echo "PayToken:<br>";
echo $PayToken,"<br>","<br>";
$MerchantTradeNo=($_POST['MerchantTradeNo']);
echo "MerchantTradeNo:<br>";
echo $MerchantTradeNo,"<br>","<br>";
date_default_timezone_set("Asia/Taipei");

$szRqHeader=array(
'Timestamp' => $Timestamp,
'Revision' => $Revision,
);

$arData = array(
    
	//特約合作平台商代號
	//'PlatformID' => '',
    
	//會員編號
	'MerchantID' => $szMerchantID,
	
	//付款代碼
	'PayToken' =>$PayToken,
	
	//交易編號
	'MerchantTradeNo' =>$MerchantTradeNo,
	
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
//echo $arParameters,"<br>","<br>";
echo "印出回傳結果<br>";
echo $szResult,"<br>","<br>";
//判斷回傳是否為Json格式
$ResultisJson=isJson($szResult);

if($ResultisJson==TRUE){

    $DataisNull=json_decode($szResult,true);

    if(isset($DataisNull["Data"])){

        if($DataisNull["Data"]!==''){

            //將Data解密並取出3D驗證網址
            $DataDec = $oCrypter->Decrypt($DataisNull["Data"]);
			$DataDec1=json_decode($DataDec,true);
			if(isset($DataDec1["ThreeDInfo"])){
				$DataDec2 = $DataDec1["ThreeDInfo"];
				$DataDec3 = $DataDec2["ThreeDURL"];
				$DataDec4 = $DataDec1["CVSInfo"];
				$DataDec5 = $DataDec4["PaymentURL"];
				$DataDec6 = $DataDec1["UnionPayInfo"];
				$DataDec7 = $DataDec6["UnionPayURL"];
				$oURL = new ToURL();
				if(is_null($DataDec3)){
					if(is_null($DataDec5)){
						if(is_null($DataDec7)){
							echo"Data內容<br>";
							echo $DataDec,"<br>";
						}
						else if(empty($DataDec7)){
							echo"Data內容<br>";
							echo $DataDec,"<br>";
						}
						else{
						echo $DataDec,"<br>";
						$url = $oURL->To3DURL($DataDec7);
						}
					}
					else if(empty($DataDec5)){
						if(is_null($DataDec7)){
							echo"Data內容<br>";
							echo $DataDec,"<br>";
						}
						else if(empty($DataDec7)){
							echo"Data內容<br>";
							echo $DataDec,"<br>";
						}
						else{
						echo $DataDec,"<br>";
						$url = $oURL->To3DURL($DataDec7);
						}
					}
					else{
						echo $DataDec,"<br>";
						$url = $oURL->To3DURL($DataDec5);
					}
					
				}
				else if(empty($DataDec3)){
					if(is_null($DataDec5)){
						echo"Data內容<br>";
						echo $DataDec,"<br>";
					}
					else if(empty($DataDec5)){
						echo"Data內容<br>";
						echo $DataDec,"<br>";
					}
					else{
						$url = $oURL->To3DURL($DataDec5);
					}
				}
				//將網頁跳轉至3D驗證
				else{
				$url = $oURL->To3DURL($DataDec3);
				}	
			}
			else{
				echo"Data內容<br>";
				echo $DataDec,"<br>";
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