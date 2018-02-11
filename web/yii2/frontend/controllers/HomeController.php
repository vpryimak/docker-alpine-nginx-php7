<?php 
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
header("Content-type:text/html;charset=utf8");
/**
 * Index controller
 */
class HomeController extends Controller
{
	
	// 关闭csrf
	public $enableCsrfValidation = false;
	public $layout = false;

	// 进行第三方授权
	public function actionIndex(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$client_id = "1106673362";
		$redirect_uri = "http://i2137.com/php/home/home";

		$url = "https://developers.e.qq.com/oauth/authorize?client_id=".$client_id."&redirect_uri=".$redirect_uri."&state=maida";
		// echo $url;die;
        return $this->render('index',array('url'=>$url));


	}

    public function actionHome(){
        // 接收code
        $authorization_code = Yii::$app->request->get('authorization_code');
        if (!empty($authorization_code)) {

            // 将code存到test.txt文件中
            $file = "test.txt";
            // echo $authorization_code."</br>";
            $result = $this->put_to_file($file,$authorization_code);
            // print_r($result);
        }
        // $result = $this->token();
        // print_r($result);die;

    }
    // 取出code,获取access_token
    public function actionToken(){
        // 取出来code
        $file = "test.txt";
        $authorization_code_res = $this->get_to_file($file);

        var_dump($authorization_code_res);
        if (!empty($authorization_code_res)) {

            $client_id = "1106673362";
            $client_secret = "k0m0gbJZj46nEFVU";
            $redirect_uri = "http://i2137.com/php/home/home";

            $Url = "https://api.e.qq.com/oauth/token?client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code&authorization_code=".$authorization_code_res."&redirect_uri=".$redirect_uri;
            echo $Url;
            $res_result = file_get_contents($Url);
            // return $res_result;
            // print_r($res_result);
            $files = "token.txt";
            $result = $this->put_to_file($files,$res_result);
            // 取出来code
            // $files = "token.txt";
            $json = $this->get_to_file($files);
            $result_res_one = json_decode($json,true);
            print_r($result_res_one);


        }else{
            echo "取不出code";
        }
    }

	/*public function actionHome(){
        // $authorization_code = Yii::$app->request->get('authorization_code')?Yii::$app->request->get('authorization_code') : '';
        $authorization_code = Yii::$app->request->get('authorization_code');
        if (!empty($authorization_code)) {
            $file = 'test.txt';
            $result = $this->put_to_file($file,$authorization_code);
           
        }

        $res = $this->get_to_file();

        if (!empty($res)) {


            $client_id = "1106673362";
            $client_secret = "k0m0gbJZj46nEFVU";
            $redirect_uri = "http://i2137.com/php/home/home";


            $url = "https://api.e.qq.com/oauth/token?client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code&authorization_code=".$res[0]."&redirect_uri=".$redirect_uri;
            // echo $url;die;
            // $url = 'https://api.e.qq.com/oauth/token?client_id=1106673362&client_secret=k0m0gbJZj46nEFVU&grant_type=authorization_code&authorization_code=2991b46d20724fa083b2f57950130df6&redirect_uri=http://i2137.com/php/home/home';
            echo $url;die;
            $result = $this->curl_request($url);
            print_r($result);
            $res = json_decode($result,true);

            print_r($res);

            $user = $res['data']['authorizer_info'];
            $account_uin = $user['account_uin'];
            $account_id = $user['account_id'];
            $access_token = $res['data']['access_token'];
            $access_token_expires_in = $res['data']['access_token_expires_in']+time();
            $refresh_token = $res['data']['refresh_token'];
            $refresh_token_expires_in = $res['data']['refresh_token_expires_in']+time();

            $Sql1 = "SELECT account_uin FROM txad WHERE account_uin='$account_uin'";
            $res1 = Yii::$app->db->createCommand($Sql1)->queryOne();


            if (!$res1) {
                $Sql = "INSERT INTO txad(account_uin,account_id,access_token,access_token_expires_in,refresh_token,refresh_token_expires_in) VALUES('$account_uin','$account_id','$access_token','$access_token_expires_in','$refresh_token','$refresh_token_expires_in')";

                // 存储到数据库
                Yii::$app->db->createCommand($Sql)->execute();
            }else{
                $Sql2 = "UPDATE txad SET access_token='$access_token',access_token_expires_in='$access_token_expires_in',refresh_token='$refresh_token',refresh_token_expires_in='$refresh_token_expires_in' WHERE account_id='$account_id'";
                Yii::$app->db->createCommand($Sql2)->execute();
            }


        }else{

            echo "获取不到authorization_code";

        }
    }*/

    // 刷新access_token
    public function actionRefresh($account_id,$refresh_token){

        $client_id = "1106673362";
        $client_secret = "k0m0gbJZj46nEFVU";
        $redirect_uri = "http://i2137.com/php/home/home";

        $url = "https://api.e.qq.com/oauth/token?client_id=".$client_id."&client_secret=".$client_secret."&grant_type=refresh_token&refresh_token=".$refresh_token;
        $result = $this->curl_request($url);
        $res = json_decode($result,true);
        print_r($res);


        $access_token = $res['data']['access_token'];
        $access_token_expires_in = $res['data']['access_token_expires_in']+time();
        $refresh_token_expires_in = $res['data']['refresh_token_expires_in']+time();

        $Sql2 = "UPDATE txad SET access_token='$access_token',access_token_expires_in='$access_token_expires_in',refresh_token_expires_in='$refresh_token_expires_in' WHERE account_id='$account_id'";
        $res = Yii::$app->db->createCommand($Sql2)->execute();
        print_r($res);

    }

    function get_to_file($file){
        $str = file_get_contents($file);//将整个文件内容读入到一个字符串中
        $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码）
        return $str_encoding;
        /*$arr = explode("\r\n", $str_encoding);//转换成数组

        //去除值中的空格
        foreach ($arr as &$row) {
            $row = trim($row);
        }

        unset($row);
        //得到后的数组
        return $arr;*/
    }
    

    //写入文件
    function put_to_file($file, $content) {
        // mkdir($file,777,true);
        $fopen = fopen($file, 'wb');
        if (!$fopen) {
            return false;
        }
        fwrite($fopen, $content);
        fclose($fopen);
        return true;
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
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
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


    //取出环境变量
    public function actionQu(){

       $result = getenv('REDIS_HOST');       
       print_r($result);
       echo "1啊";

       $res = getenv('PATH');
       print_r($res);
       echo "2呀";

    }
    // 输出phpinfo
    public function actionInfo(){
        echo phpinfo();
    }

    // 连接redis
    public function actionRedis(){

       $redis =  new \redis();
       $redis->connect('47.92.138.179', 21601);       
       $redis->auth("Mindata123"); 
       //检测是否连接成功
       echo "Server is running: " . $redis->ping();


    }


        // 获取access_token
    public function actionHuo(){

            $client_id = "1106673362";
            $client_secret = "k0m0gbJZj46nEFVU";
            $redirect_uri = "http://i2137.com/php/home/home";
            $authorization_code = "c9dd579889822dfe40d4f29786a3b82b";

            $url = "https://api.e.qq.com/oauth/token?client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code&authorization_code=".$authorization_code."&redirect_uri=".$redirect_uri;
            // echo $url;die;
            // $url = 'https://api.e.qq.com/oauth/token?client_id=1106673362&client_secret=k0m0gbJZj46nEFVU&grant_type=authorization_code&authorization_code=14b31be54394ded9f0b9de71839fa185&redirect_uri=http://i2137.com/php/home/home';
            $result = $this->curl_request($url);
            print_r($result);


    }


}

