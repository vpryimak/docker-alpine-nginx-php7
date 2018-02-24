<?php 
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
header("Content-type:text/html;charset=utf8");
/**
 * Index controller
 */
class FileController extends Controller
{
    
    // 关闭csrf
    public $enableCsrfValidation = false;
    public $layout = false;

    public function actionAddfile(){
        $access_token = "0fef5febf5fe0f24434e19e602e3cf4a";
        $timestamp = time();
        $nonce = $this->rand(10);
        $GDT['content'] = '{
            "account_id": "100001445",
            "name": "QQ号码人群",
            "type": "CUSTOMER_FILE",
            "outer_audience_id": "123",
            "description": "添加QQ号码，展示QQ空间广告",
        }';   

        $url = "https://sandbox-api.e.qq.com/v1.0/custom_audiences/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;
        // echo $url;die;
        $res = $this->curl_request($url,$GDT);
        print_r($res);die;

    }

    // 生成签名
    public function rand($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
        }
        return $string;
    }

    // curl请求
    public  function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $headers = array();
        $headers[] ='Content-Type: application/json';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }
}