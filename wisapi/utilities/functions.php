<?php
function generatePassword($password){
	return password_hash($password,PASSWORD_BCRYPT);
}
function verifyPassword($passwordToVerify,$password){
	return password_verify($passwordToVerify, $password);
}
function filterUserData($result){
	unset($result['Password'],$result['UpdatedBy'],$result['isVerified']);
	return $result;
}
function DateDiff($stdate,$enddate,$mode){
	$datetime1 = new DateTime($stdate);
	$datetime2 = new DateTime($enddate);
	$interval = $datetime1->diff($datetime2);
		
	switch($mode)
	{
		case "y": 
			return $interval->format('%y');			
			break;
		case "m":
			return $interval->format('%y')*12+$interval->format('%m');
			break;
		case "d":
			return $interval->format('%a');			
			break;
		case "h":
			return $interval->format('%a')*24+$interval->format('%h');
			break;
		case "i":
			// 1440 = 24 * 60 (hours in a day and mins in an hour)
			return $interval->format('%a')*1440+$interval->format('%h')*60+$interval->format('%i');
			break;
		case "s":
			// 86400 = 24*60*60 (hours in day and mins and seconds)
			return $interval->format('%a')*86400+$interval->format('%h')*3600+$interval->format('%i')*60+$interval->format('%s');
			break;
	}// of switch
}// of func date diff
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
function SendSMS($to,$msg){
	/*$url = "http://smslogin.mobi/spanelv2/api.php?";
	$url .= "username=rentomsotp&password=rentoms123&from=RENTOM&to=".$to."&message=".urlencode($msg);
	$ret = file($url);
	return $ret[0];*/
	return '';
}
function modifyFileName($filename){
	$str = stripslashes($filename);
	$str1= pathinfo($str);
	$extension = $str1['extension'];
	$extension = strtolower($extension);
	$image_name=$str1['filename'].'_'.time().'.'.$extension;
	return $image_name;
}
?>