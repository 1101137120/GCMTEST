<?php
// 這個php程式的作用為
// 發送 POST 給 Google GCM server，
// 並接收 Google GCM server 的回傳訊息，在某 Android 裝置已移除您的 app 時
// 做對應的處理
$regId = $_REQUEST['regId'];
$dbhost = 'localhost';
$dbuser = 'root';           //你要用來連資料庫的User Name
$dbpass = 'root';                   //對應User Name的密碼
$dbname = 'gcm';        //存放Registration ID的資料庫名稱

//建立資料庫連接
$conn= mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

				$sqlTodel = "DELETE FROM `register`  WHERE regId='".$regId."'";
				$result = mysqli_query($conn,$sqlTodel); // 執行SQL查詢
var_dump($result);
	mysqli_close($conn);		
?>
