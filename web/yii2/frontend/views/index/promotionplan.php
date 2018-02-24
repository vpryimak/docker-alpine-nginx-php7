<!DOCTYPE html>
<html>
<head>
	<title>创建推广计划</title>
</head>
<body>
	<form method="post"  action="?r=index/promotionplan">
		<!-- 推广目标：<select name="Promotion_goal">
						<option id="1" value="电商网页推广电商页面，增加商品购买量">电商网页推广电商页面，增加商品购买量</option>
						<option id="2" value="Android应用推广Android应用，增加应用的下载">Android应用推广Android应用，增加应用的下载</option>
						<option id="3" value="iOS应用推广iOS应用，增加应用的下载">iOS应用推广iOS应用，增加应用的下载</option>
						<option id="4" value="认证空间推广认证空间页，增加访问量">认证空间推广认证空间页，增加访问量</option>
						<option id="5" value="Android应用（联盟推广）在移动联盟流量上推广Android应用，增加应用的下载">Android应用（联盟推广）在移动联盟流量上推广Android应用，增加应用的下载</option>
						<option id="6" value="本地广告推广本地门店或活动，吸引本地用户到店或参加活动">本地广告推广本地门店或活动，吸引本地用户到店或参加活动</option>
						<option id="7" value="腾讯课堂推广腾讯课堂课程，增加课程报名数">腾讯课堂推广腾讯课堂课程，增加课程报名数</option>
				  </select><br></br> -->
	    计划设置<br>
	    日限额：<input type="text" name="Daily_limit"/><br>
	    投放方式:<select name="Delivery_mode">
			    	<option value="SPEED_MODE_STANDARD">标准投放</option>
			    	<option value="SPEED_MODE_FAST">加速投放</option>
			     </select></br></br>
	    推广计划名称:<input type="text" name="Extension_plan_name"></br>
	    <input type="submit" value="提交按钮">
	</form>
</body>
</html>