<?
    include_once("../common/php_module/common_func.php");

	session_start();

    //Return Array======================================
	$ret = array();						
	$ret["errCode"] = "01";
	$ret["errMsg"] = "Access denied";
	$ret["retData"] = "";

	$apiKey = check_str($_REQUEST["apiKey"]);		// API KEY
	$userID = check_str($_REQUEST["userID"]);		// 유저 ID
	$userPW = check_str($_REQUEST["userPW"]);		// 유저 PW
	$setComm = check_str($_REQUEST["setComm"]);		// 요청 명령

	//API Key Error처리======================================
	$query = "SELECT akKey FROM api_key WHERE akKey = \"" .$apiKey. "\"";
	$get_data = get_select_data($query);
	if(empty($get_data)){
		$ret["errCode"] = "03";
		$ret["errMsg"] = "Incorrect API Key";
		echo json_encode($ret);
		exit(0);	//exit(0) 하단은 실행중지
	}

	switch($setComm){
		case "login":
			$userID = check_str($_REQUEST["userID"]);
			$userPW = check_str($_REQUEST["userPW"]);

			$query = "SELECT userID, userPW, userType, farmID
						 FROM(
								(SELECT mgrID as userID, mgrPW as userPW, 'all' as farmID, 'admin' as userType  FROM manager)	/*관리자계정*/
								UNION ALL
								(SELECT fID as userID, fPW as userPW, fFarmid as farmID, 'farm' as userType FROM farm)			/*농장계정*/
						) rt
					 WHERE rt.userID = \"" .$userID. "\" AND rt.userPW = \"" .$userPW. "\" LIMIT 0, 1";
			$get_data = get_select_data($query);

			if( !empty($get_data[0]["userID"]) && !empty($get_data[0]["userType"]) && !empty($get_data[0]["farmID"])  ){
				$ret["errCode"] = "00";
				$ret["errMsg"] = "Login success";
				$ret["retData"] = array(
					"userID"   => $get_data[0]["userID"],
					"userPW" => $get_data[0]["userPW"],
					"userType" => $get_data[0]["userType"],
					"farmID" => $get_data[0]["farmID"]
				);
			}
			else{
				$ret["errCode"] = "04";
				$ret["errMsg"] = "Login failed";
				$ret["retData"] = array();
			}
			break;

		case "logout":
			break;

		case "check":
			break;
	}

	// $select_query = "SELECT * FROM farm WHERE fID = \"$userID\" AND fPW = \"$userPW\"";

	// $select_data = get_select_data($select_query);

	// if(count($select_data) == 1){
	// 	$ret_data["info"] = $select_data[0];

	// 	$ret["errCode"] = "00";
	// 	$ret["errMsg"] = ""; 
	// 	$ret["retData"] = $ret_data;


	// }
	// else{
	// 	$ret["errCode"] = "04";
	// 	$ret["errMsg"] = "Login Failed"; 
	// 	$ret["retData"] = $ret_data;
	// }

	echo json_encode($ret);
?>