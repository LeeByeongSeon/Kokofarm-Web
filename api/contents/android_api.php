<?
    include_once("../common/php_module/common_func.php");

    //Return Array======================================
	$ret = array();						
	$ret["errCode"] = "01";
	$ret["errMsg"] = "Access denied";
	$ret["retData"] = "";

	$apiKey = check_str($_REQUEST["apiKey"]);	//API KEY
	$userID = check_str($_REQUEST["userID"]);		// 유저 ID
	$setComm = check_str($_REQUEST["setComm"]);		// 요청 명령

    //기본 Error처리======================================
	if(	empty($userID) || empty($setComm) ){
		$ret["errCode"] = "02";
		$ret["errMsg"] = "Invalid request";
		echo json_encode($ret);
		exit(0);	//exit(0) 하단은 실행중지
	}

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

		case "buffer":

			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";

			$time_1 = date("Y-m-d H:i:s", strtotime("-1 hours"));
			$time_2 = date("Y-m-d H:i:s", strtotime("-24 hours"));

			$select_query = "SELECT fd.fdFarmid, fd.fdDongid, fd.fdName, f.fName, f.fGP, f.fPN, f.fFeedPer, f.fWaterPer, f.fFcrWeight, 
							be.*, cm.*, sf.*, sh.*, sl.slLight01, aw.* FROM farm AS f 
							JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid 
							JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid 
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							LEFT JOIN set_feeder AS sf ON sf.sfFarmid = fd.fdFarmid AND sf.sfDongid = fd.fdDongid 
							LEFT JOIN set_light AS sl ON sl.slFarmid = fd.fdFarmid AND sl.slDongid = fd.fdDongid 
							LEFT JOIN avg_weight AS aw ON aw.awFarmid = fd.fdFarmid AND aw.awDongid = fd.fdDongid AND awDate = \"" . substr($time_2, 0, 15) . "0:00\" 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = fd.fdFarmid AND sh.shDongid = fd.fdDongid AND shDate = \"" . substr($time_1, 0, 13) . ":00:00\" 
							WHERE f.fFarmid = \"" .$farmID. "\" ORDER BY fd.fdDongid ASC";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$ret_data[$row["fdFarmid"] . $row["fdDongid"]] = $row;
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
			break;

		case "allBuffer":

			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";

			$time_1 = date("Y-m-d H:i:s", strtotime("-1 hours"));
			$time_2 = date("Y-m-d H:i:s", strtotime("-24 hours"));

			$select_query = "SELECT fd.fdFarmid, fd.fdDongid, fd.fdName, f.fName, f.fGP, f.fPN, f.fFeedPer, f.fWaterPer, f.fFcrWeight, 
							be.*, cm.*, sf.*, sh.*, sl.slLight01, aw.* FROM farm AS f 
							JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid 
							JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid 
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							LEFT JOIN set_feeder AS sf ON sf.sfFarmid = fd.fdFarmid AND sf.sfDongid = fd.fdDongid 
							LEFT JOIN set_light AS sl ON sl.slFarmid = fd.fdFarmid AND sl.slDongid = fd.fdDongid 
							LEFT JOIN avg_weight AS aw ON aw.awFarmid = fd.fdFarmid AND aw.awDongid = fd.fdDongid AND awDate = \"" . substr($time_2, 0, 15) . "0:00\" 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = fd.fdFarmid AND sh.shDongid = fd.fdDongid AND shDate = \"" . substr($time_1, 0, 13) . ":00:00\" 
							ORDER BY fd.fdFarmid, fd.fdDongid ASC";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$ret_data[$row["fdFarmid"] . $row["fdDongid"]] = $row;
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
			break;

		case "farmList":

			$select_query = "SELECT beFarmid, MAX(beInterm) AS beInterm, COUNT(*) AS count, SUM(IF(beStatus = 'O', 0, 1)) AS comein, 
								SUM(cmInsu + cmExtraSu - cmDeathCount - cmCullCount - cmThinoutCount) AS live,
								ROUND(AVG(beAvgWeight), 1) AS beAvgWeight
							FROM buffer_sensor_status AS be
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							GROUP BY beFarmid ORDER BY beInterm DESC";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$ret_data[$row["beFarmid"]] = $row;
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
			break;

		case "cell":

			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";

			$select_query = "SELECT f.fName, fd.fdFarmid, fd.fdDongid, si.* FROM farm AS f 
							JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid 
							LEFT JOIN set_iot_cell AS si ON si.siFarmid = fd.fdFarmid AND si.siDongid = fd.fdDongid 
							WHERE f.fFarmid = \"" .$farmID. "\" ORDER BY fd.fdDongid, si.siCellid";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$id = $row["siFarmid"] . $row["siDongid"];
				
				if(!array_key_exists($id, $ret_data)){
					$ret_data[$id] = array();
				}
				$ret_data[$id][$row["siCellid"]] = $row;
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
			break;

		case "feedPer":

			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";

			$select_query = "SELECT fe.*, cd.* FROM (
							SELECT sh.shFarmid, sh.shDongid, LEFT(shDate, 10) AS shDate, 
							SUM(JSON_EXTRACT(shFeedData, \"$.feed_feed\")) AS feed, SUM(JSON_EXTRACT(shFeedData, \"$.feed_water\")) AS water, cm.cmCode, cm.cmInsu 
							FROM buffer_sensor_status AS be 
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = be.beFarmid AND sh.shDongid = be.beDongid AND sh.shDate 
								BETWEEN cm.cmIndate AND IF(cm.cmOutdate is null, now(), cm.cmOutdate)
							WHERE be.beFarmid = \"" .$farmID. "\" GROUP BY cm.cmCode, shFarmid, shDongid, LEFT(shDate, 10)
							) AS fe
							LEFT JOIN comein_detail AS cd ON cd.cdCode = fe.cmCode AND cd.cdDate = shDate";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$id = $row["shFarmid"] . $row["shDongid"];
				
				if(!array_key_exists($id, $ret_data)){
					$ret_data[$id] = array();
				}
				$ret_data[$id][$row["shDate"]] = array(
					"feed" => $row["feed"],
					"water" => $row["water"],
					"death" => $row["cdDeath"],
					"cull" => $row["cdCull"],
					"thinout" => $row["cdThinout"],
				);
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
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

		case "sensorHistory":

			$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";

			$select_query = "SELECT sh.*, IFNULL(DATEDIFF(sh.shDate, cm.cmIndate) + 1, 0) AS interm FROM comein_master AS cm 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = cm.cmFarmid AND sh.shDongid = cm.cmDongid 
								AND (shDate BETWEEN cm.cmIndate AND IFNULL(cm.cmOutdate, now())) 
							WHERE cm.cmCode = \"" . $code . "\"";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){

				$ret_data[$row["shDate"]] = array(
					"shSensorData" => $row["shSensorData"],
					"shFeedData" => $row["shFeedData"],
					"shExtSensorData" => $row["shExtSensorData"],
					"days" => $row["interm"],
				);
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = "";
			$ret["retData"] = $ret_data;
			break;

		case "comeoutList" :
			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";
			$start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : "0";
			$end = isset($_REQUEST["end"]) ? $_REQUEST["end"] : "100";

			$select_query = "SELECT fd.fdName, cm.*, aw.awWeight, IFNULL(DATEDIFF(cm.cmOutdate, cm.cmIndate) + 1, 0) AS interm 
							FROM farm_detail AS fd 
							LEFT JOIN comein_master AS cm ON cm.cmFarmid = fd.fdFarmid AND cm.cmDongid = fd.fdDongid AND cm.cmOutdate is not null 
							LEFT JOIN avg_weight AS aw ON aw.awFarmid = fd.fdFarmid AND aw.awDongid = fd.fdDongid 
								AND awDate = CONCAT(LEFT(DATE_SUB(cm.cmOutdate, INTERVAL 1 HOUR), 15), '0:00') ";
			
			if($farmID != "") {
				$select_query .= "WHERE cm.cmFarmid = \"" . $farmID . "\" ";
			}
			$select_query .= " ORDER BY cmOutdate DESC LIMIT " . $start . ", " . $end;

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$ret_data[$row["cmCode"]] = $row;
			}

			// 전체 출하 횟수 저장
			$select_query = "SELECT COUNT(*) AS cnt, COUNT(DISTINCT(cmDongid)) AS dongCnt FROM comein_master ";
			if($farmID != "") {
				$select_query .= "WHERE cmFarmid = \"" . $farmID . "\" ";
			}
			$select_data = get_select_data($select_query);
			$ret_data["cnt"] = $select_data[0]["cnt"];
			$ret_data["dongCnt"] = $select_data[0]["dongCnt"];

			$ret["errCode"] = "00";
			$ret["errMsg"] = "";
			$ret["retData"] = $ret_data;
			break;

		case "comeinDetail":

			$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";

			$select_query = "SELECT cd.*, IFNULL(DATEDIFF(cd.cdDate, cm.cmIndate) + 1, 0) AS interm, cm.* FROM comein_master AS cm 
							LEFT JOIN comein_detail AS cd ON cd.cdCode = cm.cmCode 
								AND (cd.cdDate BETWEEN cm.cmIndate AND IFNULL(cm.cmOutdate, now())) 
							WHERE cm.cmCode = \"" . $code . "\"";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){

				$ret_data[$row["cdDate"]] = $row;

				// $ret_data[$row["cdDate"]] = array(
				// 	"cdDate" => $row["cdDate"],
				// 	"shFeedData" => $row["shFeedData"],
				// 	"shExtSensorData" => $row["shExtSensorData"],
				// 	"days" => $row["interm"],
				// );
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = "";
			$ret["retData"] = $ret_data;
			break;

		case "outSensor":

			$farmID = isset($_REQUEST["farmID"]) ? $_REQUEST["farmID"] : "";

			$select_query = "SELECT * FROM set_outsensor WHERE soFarmid = \"" .$farmID. "\" ORDER BY soDongid ASC LIMIT 1";

			$select_data = get_select_data($select_query);

			$ret_data = array();

			foreach($select_data as $row){
				$id = $row["soFarmid"];
				$ret_data[$id] = $row;
			}

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;
			break;

		case "saveBreedData":

			$insert_map = array();

			$code = isset($_REQUEST["cdCode"]) ? $_REQUEST["cdCode"] : "";
	
			$insert_map["cdCode"] 	    	= $code;			//입출하 코드
			$insert_map["cdDate"] 	    	= check_str($_REQUEST["cdDate"]); 									//입력 기준시간
	
			$insert_map["cdDeath"] 	 		= check_str($_REQUEST["cdDeath"]); 			//폐사 수
			$insert_map["cdCull"]   		= check_str($_REQUEST["cdCull"]); 			//도태 수
			$insert_map["cdThinout"]    	= check_str($_REQUEST["cdThinout"]); 		//솎기 수
			$insert_map["cdInputDate"]  	= date("Y-m-d H:i:s");
	
			run_sql_upsert("comein_detail", $insert_map, array("cdCode", "cdDate"));

			$cmInsu = check_str($_REQUEST["cmInsu"]);
			$cmExtraSu = check_str($_REQUEST["cmExtraSu"]);
			$cmAlreadyFeed = check_str($_REQUEST["cmAlreadyFeed"]);
	
			// 입추수 변경
			$update_query = "UPDATE comein_master AS cm 
								JOIN (
									SELECT cm.*, SUM(cd.cdDeath) AS cdDeath, SUM(cd.cdCull) AS cdCull, SUM(cd.cdThinout) AS cdThinout FROM comein_master AS cm 
									LEFT JOIN comein_detail AS cd ON cd.cdCode = cm.cmCode
									WHERE cmCode = \"".$code."\" GROUP BY cm.cmCode
								) AS t ON cm.cmCode = t.cmCode SET ";
			$update_query .= " cm.cmInsu = " . $cmInsu;
			$update_query .= ", cm.cmDeathCount = t.cdDeath";
			$update_query .= ", cm.cmCullCount = t.cdCull";
			$update_query .= ", cm.cmThinoutCount = t.cdThinout";
			$update_query .= ", cm.cmExtraSu = " . $cmExtraSu;
			$update_query .= ", cm.cmAlreadyFeed = " . $cmAlreadyFeed;
			$update_query .= " WHERE cm.cmCode = \"".$code."\"";

			run_query($update_query);

			$ret_data = array();
			$ret_data["result"] = "true";

			$ret["errCode"] = "00";
			$ret["errMsg"] = ""; 
			$ret["retData"] = $ret_data;

	
			break;

	}

	echo json_encode($ret);
?>