<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
header("Content-type:text/html;charset=utf8");
/**
 * Index controller
 */
class IndexController extends Controller
{	
	// 关闭csrf
	public $enableCsrfValidation = false;
	public $layout = false;

	// 获取账号的信息
	public function actionIndex(){

        // 取出来code
        $files = "token.txt";
        $json = $this->get_to_file($files);
        // print_r($json);die;
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$nonce = $this->rand(10);
		$timestamp = time();

		$filtering = '[{"field":"corporation_name","operator":"CONTAINS","values":["腾讯"]}]';

		$url = "https://api.e.qq.com/v1.0/advertiser/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&filtering=".$filtering."&page=1&page_size=10";
		// echo $url;die;
		

		$result = $this->curl_request($url);
		print_r($result);die;
	}


	// 获取资金账号信息
	public function actionAccount(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$url = "https://api.e.qq.com/v1.0/funds/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);
	}


	// 申请服务商子客账号
	public function actionServiceprovider(){ //生成的服务商子客账号 100001445

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];


		$GDT['corporation_name']='腾讯计算机系统有限公司';
		$GDT['certification_image_id']='1378:ebd186f350cea77a931dd34adf06d391';
		$GDT['website']='https://www.tencent.com';
		$GDT['icp_image_id']='1378:ebd186f350cea77a931dd34adf06d391';
		$GDT['individual_qualification']=array('identification_front_image_id'=>'1378:ebd186f350cea77a931dd34adf06d391','identification_back_image_id'=>'1378:ebd186f350cea77a931dd34adf06d391');
		$GDT['system_industry_id']='21474840687';
		// $GDT['industry_qualification_image_id_list']='1378:ebd186f350cea77a931dd34adf06d391';
		// $GDT['ad_qualification_image_id_list']='1378:ebd186f350cea77a931dd34adf06d391';
		$GDT['corporate_image_name']='腾讯';
		$GDT['contact_person_telephone']='0755-86013388';
		$GDT['contact_person_mobile']='13900000000';
		$GDT['contact_person_telephone']='0755-86013388';
		$GDT['contact_person_telephone']='0755-86013388';

		$url = "https://e.qq.com/v1.0/advertiser/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);
		
	}
		
	public function actionPromotionplanindex(){
		return $this->render('promotionplan.php');
	}


	//创建推广计划
	public function actionPromotionplan(){ //创建的推广计划id 2671/2661/2709

		$GDT['account_id'] = "4002594"; //广告主帐号 id
		$GDT['campaign_name'] = "春节大促销"; //推广计划名称
		$GDT['campaign_type'] = "CAMPAIGN_TYPE_NORMAL"; //推广计划类型
		$GDT['product_type'] = "PRODUCT_TYPE_LINK"; //标的物类型
		$GDT['daily_budget'] = "50000"; //日消耗限额
		$GDT['configured_status'] = "AD_STATUS_SUSPEND"; //客户设置的状态
		$GDT['speed_mode'] = "SPEED_MODE_STANDARD"; //投放速度模式


		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];


		$url = "https://api.e.qq.com/v1.0/campaigns/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);

	}
	// 获取广告计划
	public function actionPromotionplanget(){

		
		// $GDT['campaign_id']= "";
		$filtering = '[{"field":"campaign_name","operator":"CONTAINS","values":["腾讯"]}]';
		$page = "1";
		$page_size = "10";
		// print_r($GDT);die;

		$nonce = $this->rand(10);
		$timestamp = time();


		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

        
		$url = "https://api.e.qq.com/v1.0/campaigns/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&filtering=".$filtering."&page=".$page."&page_size=".$page_size;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);die;


	}
	// 创建定向
	public function actionDirectional(){ //创建的定向id 13179
 

		$GDT['account_id'] = "100001445";
		$GDT['targeting_name'] = "定向";
		$GDT['targeting'] = '{"gender":["MALE"],"age":["18~30"],"geo_location":{"regions":[110000,310000],"location_types":["LIVE_IN"]}}';
		$GDT['description'] = "description";


		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];	

		$url = "https://e.qq.com/v1.0/targetings/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);

		

	}


	// 获取广告定向
	public function actionDirectionalget(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];	

		$page="1";
		$page_size="10";
		$filtering='[{"field":"targeting_name","operator":"EQUALS","values":["腾讯"]}]';

		$url = "https://api.e.qq.com/v1.0/targetings/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&page=".$page."&page_size=".$page_size;

		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);


	}


	//创建广告组
	public function actionAdvertisinggroup(){  //创建的广告组 13814


		$GDT['account_id'] = "100001445"; //广告主帐号 id
		$GDT['campaign_id'] = "2709"; //推广计划 id
		$GDT['adgroup_name'] = '推广广告1'; //广告组名称
		$GDT['site_set'] = '["SITE_SET_QZONE"]'; //投放站点集合
		$GDT['product_type'] = "PRODUCT_TYPE_LINK"; //标的物类型(普通连接)
		$GDT['begin_date'] = "2018-01-25"; //开始投放日期
		$GDT['end_date'] = "2018-03-02"; //结束投放日期
		$GDT['billing_event'] = "BILLINGEVENT_CLICK"; //计费类型
		$GDT['bid_amount'] = "200"; //广告出价，单位为分
		$GDT['optimization_goal'] = "OPTIMIZATIONGOAL_CLICK"; //广告优化目标类型
		// $GDT['daily_budget'] = ''; //日限额，单位为分
		$GDT['targeting_id'] = "13179"; //定向 id，与 targeting 不能同时填写且不能同时为空，仅非微信流量广告可使用
		$GDT['time_series'] = "010100100110100010101010010101010101010100101010101010010101010101001010101010100101010101010111110010101001010110110100110001011001010100101010101010110011001010101010100101100101101110101010101010100110100110010100110101110111101110110110110110110110101101101101110110011101011101101011101101101101001010110111010111011010110110111011"; //投放时间段
		$GDT['configured_status'] = "AD_STATUS_NORMAL"; //客户设置的状态(有效)
		$GDT['customized_category'] = "本地生活,餐饮";  //自定义分类
		$GDT['frequency_capping'] = "800"; //最高曝光频次，仅限部分投放视频 CPM 广告的客户设置，仅限部分投放视频 CPM 广告的客户设置

		// print_r($GDT);die;

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$url = "https://e.qq.com/v1.0/adgroups/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);

	}

	// 获取广告组
	public function actionAdvertisinggroupget(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		// $adgroup_id = "";
		// $filtering = '[{"field":"end_date","operator":"EQUALS","values":["2017-10-29"]}]';
		$page = "1";
		$page_size = "10";

		$url = "https://api.e.qq.com/v1.0/adgroups/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&page=".$page."&page_size=".$page_size;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);


	}

	// 创建标的物
	public function actionSubjectmatter(){  //普通连接不需要创建标的物

		$GDT['account_id'] = "100001445";
		$GDT['product_name'] = "标的物";
		$GDT['product_type'] = "PRODUCT_TYPE_LINK";
		$GDT['product_refs_id'] = "";

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$url = "https://e.qq.com/v1.0/products/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);


	}


	// 获取标的物
	public function actionSubjectmatterget(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$page = "1";
		$page_size = "10";

		$product_type = "PRODUCT_TYPE_APP_IOS";
		$product_refs_id = "1212200349";

		$url = "https://api.e.qq.com/v1.0/products/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&product_type=".$product_type."&product_refs_id=".$product_refs_id."&page=".$page."&page_size=".$page_size;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);



	}
	// 广告创意
	public function actionCreativity(){   //创建的创意id  46057

 		
		$GDT['account_id'] = "100001445"; //广告主帐号 id
		$GDT['campaign_id'] = "2709"; //推广计划id
		$GDT['adcreative_name'] = "广告创意"; //广告创意名称
		$GDT['adcreative_template_id'] = "2"; //创意规格 id
		$GDT['adcreative_elements'] = '{"image":"100001445:634311e792dd860727458e24b71180fc","title":"腾讯效果推广"}';//	创意元素
		$GDT['destination_url'] = "https://www.example.com"; //落地页 url
		$GDT['site_set'] = '["SITE_SET_QZONE"]'; //投放站点集合
		$GDT['product_type'] = "PRODUCT_TYPE_LINK"; //标的物类型
		// $GDT['product_refs_id'] = "PRODUCT_TYPE_LINK"; //标的物 id
		// $GDT['share_info'] = '{"share_title":"你好","share_description":"你好啊"}';
		// $GDT['share_info'] = array('share_title'=>'你好','share_description'=>'你好啊');

		
		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];	

		$url = "https://e.qq.com/v1.0/adcreatives/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);

	}

	// 获取广告创意
	public function actionCreativityget(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];
		$page = "1";
		$page_size = "10";

		$filtering = '[{"field":"adcreative_name","operator":"EQUALS","values":["三国志"]}]';
		// $adcreative_id = "";

		$url = "https://api.e.qq.com/v1.0/adcreatives/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&page=".$page."&page_size=".$page_size;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);

	}

	//创建广告
	public function actionAdvertising(){  //创建的广告id 22559
			
	    $GDT['account_id'] = "100001445"; //广告主帐号 id
	    $GDT['adgroup_id'] = "13814"; //广告组 id
	    $GDT['adcreative_id'] = "46057"; //广告创意 id
	    $GDT['ad_name'] = "推广广告"; //广告名称
	    $GDT['configured_status'] = "AD_STATUS_NORMAL"; //客户设置的状态
	    $GDT['impression_tracking_url'] = "http://miaozhen.com/track?from=tencent&aid=30304"; //曝光监控地址
	    $GDT['click_tracking_url'] = "http://miaozhen.com/track2?from=tencent&aid=30304"; //点击监控地址
	    $GDT['feeds_interaction_enabled'] = "INTERACTION_DISABLED"; //是否支持赞转评


		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$url = "https://e.qq.com/v1.0/ads/add?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce;

		$result = $this->curl_request($url,$GDT);
		print_r($result);


	}
	// 获取完整的广告信息
	public function actionAdvertisingget(){

		$nonce = $this->rand(10);
		$timestamp = time();

		$files = "token.txt";
        $json = $this->get_to_file($files);
        $result_res_one = json_decode($json,true);

        $account_id = $result_res_one['data']['authorizer_info']['account_id'];
        $access_token = $result_res_one['data']['access_token'];

		$page = "90";
		$page_size = "10";

		$url = "https://api.e.qq.com/v1.0/ads/get?access_token=".$access_token."&timestamp=".$timestamp."&nonce=".$nonce."&account_id=".$account_id."&page=".$page."&page_size=".$page_size;
		// echo $url;die;
		$result = $this->curl_request($url);
		print_r($result);



	}
	// 从文件中取出字符串
	function get_to_file($file){
        $str = file_get_contents($file);//将整个文件内容读入到一个字符串中
        $str_encoding = mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//转换字符集（编码）
        return $str_encoding;
    }


    //将字符串写入文件
    function put_to_file($file, $content) {
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



}