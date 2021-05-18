<?
	//include_once("common_func.php");

	//$cameraInfo=$_SESSION["cameraInfo"];

	$cameraIP=$_REQUEST["IP"]; //카메라IP
	$cameraPORT=$_REQUEST["PORT"]; //카메라PORT
	$cameraURL=urldecode($_REQUEST["URL"]); //카메라URL
	$cameraID=$_REQUEST["ID"]; //카메라ID
	$cameraPW=$_REQUEST["PW"]; //카메라PW
 


	$accessURL="http://" . $cameraIP . ":" . $cameraPORT . $cameraURL;

	if($cameraID!="" && $cameraPW!="" && $cameraIP!=""){
		$ch=curl_init();
		//curl_setopt($ch, CURLOPT_TIMEOUT,1);				//Request time Out : 1초	   (강제조정)
		curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000);			//Request time Out : 밀리초 (강제조정)
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $accessURL);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, '');
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $cameraID . ":" . $cameraPW);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;
	}

?>