<?php

$apiKey = 'AIzaSyDe0fZHzqnSyi8Gd80JFT72evc3DKkCE7o';                

$dbhost = 'localhost';
$dbuser = 'root';          
$dbpass = 'root';              
$dbname = 'gcm';      

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
mysql_query("SET NAMES 'utf8'");
mysql_select_db($dbname);  


$sql = "SELECT regId FROM  register";
$rs = mysql_query($sql);

$recnt = mysql_num_rows($rs);   


$SendMax = 1000;   
$SendLoop = ceil($recnt/$SendMax);

for($x=0;$x<$SendLoop;$x++)
{
    $aRegID = array();    
    
    for($y=0;$y<$SendMax;$y++)
    {
        $index = ($x*$SendMax) + $y;    
        if($index<$recnt)
            {
                $row = mysql_fetch_row($rs);
                array_push($aRegID, $row[0]);              
            }
        else
            {
                break;
            }
    }     

    $url = 'https://android.googleapis.com/gcm/send';

    $fields = array('registration_ids'  => $aRegID,
                           'data'                  => array( 'message1' => $message1,
                                                                     'message2' => $message2,
                                                                     'message3' => $message3,
                                                                  )
                          );

    $headers = array('Content-Type: application/json', 
                               'Authorization: key='.$apiKey
                    );

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
  
    echo $result;
    $aGCMresult = json_decode($result,true);
    $aUnregID = $aGCMresult['results'];
    $unregcnt = count($aUnregID);
    for($i=0;$i<$unregcnt;$i++)
    {
        $aErr = $aUnregID[$i];
        if($aErr['error']=='NotRegistered')
        {
            $sqlTodel = "DELETE FROM register         
                             WHERE regId='".$aRegID[$i]."' ";
            $rs2=mysql_query($sqlTodel);
            echo $rs2;
        }
    }
    curl_close($ch);
    unset($aRegID);
}
?>