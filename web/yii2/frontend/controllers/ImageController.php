<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Image controller
 */
class ImageController extends Controller
{	
	// 关闭csrf
	public $enableCsrfValidation = false;
	public $layout = false;

	public function actionImage()
    {
        return $this->render('index');
    }

	public function actionAdd(){
		// $signature = md5_file('d:/now/640960.jpg');
		// echo $signature;die;
		$result = $this->post('/images/add',array('account_id'=>1378,'file'=>'@d:/now/640960.jpg','signature'=>md5_file('d:/now/640960.jpg')),array("Content-Type:multipart/form-data"));
		print_r($result);

			
	}

	function post($url,$param,$header=null){

		$url=sprintf("https://sandbox-api.e.qq.com/v1.0/%s?access_token=0fef5febf5fe0f24434e19e602e3cf4a&nonce=%s&timestamp=%s",$url,time(),time());

		$ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        $header ? curl_setopt($ch, CURLOPT_HTTPHEADER, $header) : true;
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	        curl_setopt($ch, CURLOPT_TIMEOUT,5);
	        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
			$res=curl_exec($ch);
	        $status = curl_getinfo($ch);
	        $errno = curl_errno($ch);
	        if($errno || $status['http_code'] != 200)
	        {
	            var_dump(errno,$status);
	        }else{
	            var_dump($res);
	        }
	} 

}