<?php

$regId = $_REQUEST['regId'];
$dbhost = 'localhost';
$dbuser = 'root';           //你要用來連資料庫的User Name
$dbpass = 'root';                   //對應User Name的密碼
$dbname = 'gcm';        //存放Registration ID的資料庫名稱


//建立資料庫連接
$conn= mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// 列出要發送的 user 端 Android 裝置
//$sql = "SELECT regId FROM  TB_Name";
//$rs = mysql_query($sql);
//$row = mysql_fetch_row($rs);
$selectresult= false;
$sql = "SELECT regId FROM `register`";
$result = mysqli_query($conn,$sql); // 執行SQL查詢

                        $total_records=mysqli_num_rows($result);  // 取得記錄數
                        for($i=0;$i<$total_records;$i++){
                                $row = mysqli_fetch_row($result);
                        if($row[0]==$regId)
                   	{	$selectresult=true;
			var_dump('not');
			}
			}
			if($selectresult!=true){
var_dump('in');
				$sqlTodel="INSERT INTO `register`(`regId`) VALUES ('".$regId."')";
$result = mysqli_query($conn,$sqlTodel);
var_dump($result);
}
	mysqli_close($conn);		
?>

