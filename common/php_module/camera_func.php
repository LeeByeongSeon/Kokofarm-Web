<?
	$camera_ip			= $_REQUEST["ip"];				//카메라IP
	$camera_port 		= $_REQUEST["port"];			//카메라PORT
	$camera_url			= urldecode($_REQUEST["url"]);  //카메라URL
	$camera_id			= $_REQUEST["id"];				//카메라ID
	$camera_pw			= $_REQUEST["pw"];				//카메라PW

	$access_url = "http://" . $camera_ip . ":" . $camera_port . $camera_url; //주소세팅

	if($camera_id!="" && $camera_pw!="" && $camera_ip!=""){
		$ch=curl_init();									//curl 초기화 로딩
		//curl_setopt($ch, CURLOPT_TIMEOUT,1);				//Request time Out : 1초	   (강제조정)
		curl_setopt($ch, CURLOPT_TIMEOUT_MS,5000);			//Request time Out : 밀리초 (강제조정)
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $access_url);			//URL 지정하기 curl에 url 세팅
		//curl_setopt($ch, CURLOPT_POSTFIELDS, '');
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $camera_id . ":" . $camera_pw);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;
	}

?>