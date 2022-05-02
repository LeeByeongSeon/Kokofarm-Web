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

	$ret = array();

	switch($setComm){

		case "home":

			$time_1 = date("Y-m-d H:i:s", strtotime("-1 hours"));

			$select_query = "SELECT f.fName, fd.fdFarmid, fd.fdDongid, be.*, cm.*, sf.*, so.soFarmid, 
							IFNULL(DATEDIFF(IF(cm.cmOutdate is null, current_date(), cm.cmOutdate), cm.cmIndate) + 1, 0) AS interm FROM farm AS f 
							JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid 
							JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid 
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							LEFT JOIN set_feeder AS sf ON sf.sfFarmid = fd.fdFarmid AND sf.sfDongid = fd.fdDongid 
							LEFT JOIN set_outsensor AS so ON so.soFarmid = fd.fdFarmid AND so.soDongid = fd.fdDongid 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = fd.fdFarmid AND sh.shDongid = fd.fdDongid AND shDate = \"" . substr($time_1, 0, 13) . ":00:00\" 
							WHERE f.fID = \"" .$userID. "\"";

			$select_data = get_select_data($select_query);

			$ret["errCode"] = "00";
			$ret["errMsg"] = "";
			$ret["retData"] = $select_data;
			break;

		case "avgWeight":

			$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";

			$select_query = "SELECT cm.cmCode, IFNULL(DATEDIFF(aw.awDate, cm.cmIndate) + 1, 0) AS interm, aw.*, c.cName3 AS refWeight, fd.fdName FROM comein_master AS cm 
					JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid 
					JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid AND RIGHT(aw.awDate, 5) = '00:00' 
						AND (aw.awDate BETWEEN cm.cmIndate AND IF(cm.cmOutdate is null, now(), cm.cmOutdate))
					LEFT JOIN codeinfo AS c ON c.cGroup = '권고중량' AND c.cName1 = cm.cmIntype AND c.cName2 = DATEDIFF(aw.awDate, cm.cmIndate) + 1 
					WHERE cm.cmCode = \"" .$code. "\" ORDER BY aw.awDate ASC";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){

				$ret_data[$row["awDate"]] = array(
					"awWeight" => $row["awWeight"],
					"refWeight" => $row["refWeight"],
					"days" => $row["interm"],
				);
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = "";
			$ret["first"] = $select_data[0]["awDate"];
			$ret["retData"] = $ret_data;
			break;

	}

	echo json_encode($ret);
?>