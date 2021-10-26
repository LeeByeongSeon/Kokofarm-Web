<?
    include_once("../common/php_module/common_func.php");

    //Return Array======================================
	$response = array();						
	$response["errCode"] = "01";
	$response["errMsg"] = "Access denied";
	$response["retData"] = "";

	$apiKey = check_str($_REQUEST["apiKey"]);	//API KEY
	$userType = check_str($_REQUEST["userType"]);	// 유저 형식
	$userID = check_str($_REQUEST["userID"]);		// 유저 ID
	$setComm = check_str($_REQUEST["setComm"]);		// 요청 명령

    //기본 Error처리======================================
	if(	empty($userID) || empty($userType) || empty($setComm) ){
		$response["errCode"] = "02";
		$response["errMsg"] = "Invalid request";
		echo json_encode($response);
		exit(0);	//exit(0) 하단은 실행중지
	}

	//API Key Error처리======================================
	$query = "SELECT akKey FROM api_key WHERE akKey = \"" .$apiKey. "\"";
	$get_data = get_select_data($query);
	if(empty($get_data)){
		$response["errCode"] = "03";
		$response["errMsg"] = "Incorrect API Key";
		echo json_encode($response);
		exit(0);	//exit(0) 하단은 실행중지
	}

	switch($userType){
		case "manager":
			$response = work_manager($setComm);
			break;

		case "user":
			$response = work_user($setComm);
			break;
	}

	echo json_encode($response);

	function work_manager($setComm){

		$ret = array();

		switch($setComm){
			case "request":
				$query = "SELECT * FROM request_calculate WHERE rcStatus = \"R\"";
				$select_data = get_select_data($query);
				
				$ret["errCode"] = "00";
				$ret["errMsg"] = "";
				$ret["retData"] = count($select_data);
				
				break;
		}

		return $ret;
	}

	function work_user($setComm){

		$ret = array();

		switch($setComm){
			case "recalculate":
				$query = "SELECT * FROM ";

				$ret["errCode"] = "00";
				$ret["errMsg"] = "";
				$ret["retData"] = "";
				break;
		}

		return $ret;
	}
?>