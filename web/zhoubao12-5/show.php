<?php 
// error_reporting(0);
define('IN_QY',true);
session_start();

include("./include/common.inc.php");
include("./include/pdo.class.php");

$mydabase=new DB("172.26.249.246","md","maida6868","zhoubao");
// $mydabase=new DB("127.0.0.1","root","root","zhoubao");

 if (empty($_GET['essen_id'])) {
   $sql = "SELECT * FROM essential_information WHERE weekly_newspaper_ctime=(SELECT MAX(weekly_newspaper_ctime) FROM  essential_information WHERE weekly_newspaper_type=1)";
   $result=$mydabase->mysql_query_rest($sql);
}else{
    $sql = "SELECT * FROM essential_information WHERE essen_id=".$_GET['essen_id'];
    $result=$mydabase->mysql_query_rest($sql);
}

// print_r($result);die;
$sql = "SELECT * FROM content WHERE relevance_id=".$result['essen_id'];
$res=$mydabase->mysql_query_fetchAll($sql);
// print_r($res);die;
// 循环处理数组
foreach ($res as $key => $value) {
    // 键值为0的是正文第一页的内容
    $Title0 = $res[0]['title'];
    $Content0 = explode('@#$',$res[0]['content']);
    $page0 = $res[0]['page'];
    

    $Title1 = $res[1]['title'];
    $Content1 = $res[1]['content'];
    $page1 = $res[1]['page'];
    // print_r($Content1);die;

    // 键值为1的是分项进展总结的第一条
    $Title2 = $res[2]['title'];
    $Content2 = explode('@#$%', $res[2]['content']);
    // print_r($Content2);die; 
    $Title2_1 = $Content2[0];
    $Content2_1 = explode('@#$', $Content2[1]);
    $page2 = $res[2]['page'];
    // print_r($Content2_1);die;

    // 键值为2的是分项进展总结的第二条
    $Title3 = $res[3]['title'];
    $Content3 = explode('@#$%', $res[3]['content']);
    // print_r($Content3);die;
    $Title3_1 = $Content3[0];
    $Content3_1 = explode('@#$', $Content3[1]);
    $page3 = $res[3]['page'];
    // print_r($Content3_1);die;


    // 键值为3的是分项进展总结的第三条
    $Title4 = $res[4]['title'];
    $Content4 = explode('@#$%', $res[4]['content']);
    // print_r($Content4);die;
    $Title4_1 = $Content4[0];
    $Content4_1 = explode('@#$', $Content4[1]);
    $page4 = $res[4]['page'];
    // print_r($Content4_1);die;
}
// print_r($res);die;

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>麦达数字技术部工作周报</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no">

    <script src="js/flexible_css.js"></script>
    <script src="js/flexible.js"></script>

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/page/index.css">
</head>
<body>
    <div class="containers">
        <div class="page page-home" id="page0">
            <!--首页-->
            <img src="http://i2137.com/php/zhoubao12-4/images/edit.jpg" style="float: right;width: 10%;height: 10%;margin:0 auto;">
        </div>
        <div class="page" id="page1">
            <div class="title">
                <div class="title-content">
                    <span class="title-1"></span>
                    <h3><?=$Title0;?></h3>
                    <p class="title-line"></p>
                </div>
            </div>
            <div class="list-border">
                <p></p>
                <ul class="part">
                    <?php for ($i=0; $i <count($Content0); $i++) { ?>
                        <li><?=$Content0[$i];?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
         <div class="page" id="page2">
            <div class="title">
                <div class="title-content">
                    <span class="title-1"></span>
                    <h3><?=$Title1; ?></h3>
                    <p class="title-line"></p>
                </div>
            </div>
            <div class="list-border">
                <ul class="part">
                    <li><?=$Content1;?></li>                    
                </ul>
                <img src="temp/4.png">
            </div>
        </div>
        <div class="page" id="page3">
            <div class="title">
                <div class="title-content">
                    <span class="title-2"></span><h3><?=$Title2;?></h3><p class="title-line"></p>
                </div>
            </div>
            <div class="list-border">
                <h4><?=$Title2_1;?></h4>
                <ul class="small">
                    <?php for ($i=0; $i <count($Content2_1); $i++) { ?>
                        <li><?=$Content2_1[$i];?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="page" id="page4"> 
            <div class="title">
                <div class="title-content">
                    <span class="title-2"></span>
                    <h3><?=$Title3;?></h3>
                    <p class="title-line"></p>
                </div>
            </div>
            <div class="list-border">
                <h4><?=$Title3_1;?></h4>
                <ul class="small">
                    <?php for ($i=0; $i <count($Content3_1); $i++) { ?>
                        <li><?=$Content3_1[$i];?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="page" id="page5">
            <div class="title">
                <div class="title-content">
                    <span class="title-2"></span>
                    <h3><?=$Title4;?></h3>
                    <p class="title-line"></p>
                </div>
            </div>
            <div class="list-border">
                <h4><?=$Title4_1;?></h4>
                <ul class="small">
                    <?php for ($i=0; $i <count($Content4_1); $i++) { ?>
                        <li><?=$Content4_1[$i];?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="page" id="page6">
            <div class="title">
                <div class="title-content">
                    <span class="title-3"></span><h3>团队人员情况</h3><p class="title-line"></p>
                </div>
            </div>
            <div class="list-borders">
                <div class="list">
                    <ul>
                        <li><span class="list-icon"></span><p>目前在职：<span>14</span>人</p></li>
                        <li><span class="list-icon"></span><p>计划入职：无</p></li>
                        <li><span class="list-icon"></span><p>本周面试：<span>13</span>人</p></li>
                        <li><span class="list-icon"></span><p>人员缺口：算法和数据、爬虫采集、前端开发</p></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page" id="page7">
            <div class="title">
                <div class="title-content">
                    <span class="title-4"></span><h3>总体阶段进展</h3><p class="title-line"></p>
                </div>
            </div>
            <div class="progress"></div>
            <div class="charts" style="height: 7.8rem;">
                <div class="chart-title">整体阶段进展</div>
                <div class="chart" id="chart-total" style="width: 9.6rem;height: 6.8rem;"></div>
            </div>
        </div>
        <div class="page" id="page8">
            <div class="title">
                <div class="title-content">
                    <span class="title-5"></span><h3>关键子项目进展</h3><p class="title-line"></p>
                </div>
            </div>
            <div class="images">
                <p><span class="icon"></span>EC数据和模型合作项目</p>
                <img src="temp/1.png">
            </div>
            <div class="images">
                <p><span class="icon"></span>4000万企业数据采集</p>
                <img src="temp/2.png">
            </div>
            <div class="images">
                <p><span class="icon"></span>营销线索平台迭代</p>
                <img src="temp/3.png">
            </div>
        </div>
    </div>
    <!--script-->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/islider.min.js"></script>
    <script src="js/echarts.min.js"></script>
    <script src="js/echarts-map-china.min.js"></script>
    <script src="js/page/index.js"></script>
    <script type="text/javascript">
        $("#page0 img").bind("click",function(){
           window.location.href="index.php?essen_id=<?php echo $result['essen_id'];?>";
        })
    </script>
</body>
</html>
