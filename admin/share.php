<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	// 数据库配置
	$mysql = file_get_contents("../admin.json");
	$mysql_arr = json_decode($mysql,true);
	$servername = $mysql_arr["dbservername"];
	$username = $mysql_arr["dbusername"];
	$password = $mysql_arr["dbpassword"];
	$dbname = $mysql_arr["dbname"];

	// 创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);

	// 获取数据
	$hm_id = $_GET["hmid"];

	if(empty($hm_id)){
		$result = array(
			"result" => "101",
			"msg" => "非法请求"
		);
	}else{
		// 生成网址
		$SERVER='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$url = dirname(dirname($SERVER))."/index.php?hmid=".$hm_id;
		$result = array(
			"result" => "100",
			"msg" => "生成成功",
			"url" => $url
		);
	}
	// 返回结果
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}else{
	$result = array(
		"result" => "102",
		"msg" => "未登录"
	);
	// 未登录
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
?>