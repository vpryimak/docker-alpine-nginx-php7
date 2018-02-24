<!DOCTYPE html>
<html>
<head>
	<title>创建广告组</title>
</head>
<body>
	<form method="post"  action="?r=index/advertisinggroup">
		广告组名称：<input type="text" name="adgroup_name"><br>
		开始时间：<input type="text" name="begin_date" value="YYYY-mm-dd"><br>		
		结束时间：<input type="text" name="end_date" value="YYYY-mm-dd"><br>
		计费方式：<select name="billing_event">
			<option value="BILLINGEVENT_CLICK">cpc（按点击收费）</option>
			<option value="BILLINGEVENT_IMPRESSION">cpm（按千次展示收费）</option>
		</select><br>
	    <input type="submit" value="提交按钮">
	</form>
</body>
</html>