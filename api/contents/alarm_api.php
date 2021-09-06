<?
    include_once("../common/php_module/common_func.php");

    //Return Array======================================
	$response = array();						
	$response["errCode"] = "00";
	$response["errMsg"] = "Access denied";
	$response["retData"] = array();

	$apiKey = check_str($_REQUEST["apiKey"]);	//API KEY
	$setComm = check_str($_REQUEST["setComm"]);	//명령어

    //기본 Error처리======================================
	if(	empty($apiKey) || empty($setComm) ){
		$response["errCode"] = "00";
		$response["errMsg"] = "There is no API Key or command ";
		echo json_encode($response);
		exit(0);	//exit(0) 하단은 실행중지
	}

	//API Key Error처리======================================
	$query = "SELECT akKey FROM api_key WHERE akKey = \"" .$apiKey. "\"";
	$get_data = get_select_data($query);
	if(empty($get_data)){
		$response["errCode"]="00";
		$response["errMsg"]="API Key is incorrect";
		echo json_encode($response);
		exit(0);	//exit(0) 하단은 실행중지
	}

    //명령어 처리=========================================
	switch($setComm){
		case "Day":	//로그인 명령어
			$userID = check_str($_REQUEST["userID"]);
			$userPW = check_str($_REQUEST["userPW"]);

			$query="SELECT userID, userType, farmID
						 FROM(
								(SELECT mgrID as userID, mgrPW as userPW, 'ALL' as farmID, 'ADMIN' as userType  FROM manager)	/*관리자계정*/
								UNION ALL
								(SELECT fID as userID, fPW as userPW, fFarmid as farmID, 'FARM' as userType FROM farm)			/*농장계정*/
						) resultTable
					 WHERE resultTable.userID = \"" .$userID. "\" AND resultTable.userPW = \"" .$userPW. "\" LIMIT 0, 1";
			$get_data = get_select_data($query);

			if( !empty($get_data[0]["userID"]) && !empty($get_data[0]["userType"]) && !empty($get_data[0]["farmID"])  ){
				$response["errCode"] = "01";
				$response["errMsg"] = "Login success";
				$response["retData"] = array(
					"userID"   => $get_data[0]["userID"],
					"userType" => $get_data[0]["userType"],
					"farmID" => $get_data[0]["farmID"]
				);
			}
			else{
				$response["errCode"] = "00";
				$response["errMsg"] = "Login failed";
				$response["retData"] = array();
			}

			break;
	}

	echo json_encode($response);
?>