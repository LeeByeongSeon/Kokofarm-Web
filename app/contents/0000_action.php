<?

	include_once("../common/php_module/common_func.php");

	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $cmCode)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	}

	switch($oper){
		// case "get_dong_list":

		// 	$select_query = "SELECT fd.fdDongid, be.beAvgWeight, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS inTerm FROM comein_master AS cm
		// 					LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
		// 					LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
		// 					WHERE cmCode=\"$cmCode\"";

		// 	$get_data = get_select_data($select_query);

		// 	// $curr_interm = $get_data[0]["inTerm"];

		// 	// $response["summary"] = $curr_interm;

		// 	foreach($get_data as $val){
		// 		$dong_data[] = array(
		// 			'f1' => $val["fDongid"],
		// 			'f2' => $val["inTerm"],
		// 			'f3' => sprintf('%0.1f', $val["beAvgWeight"]),
		// 			'f4' => $val[""],
		// 			'f5' => $val[""],
		// 			'f6' => $val[""],
		// 		);
		// 	}

		// 	$responsep["summary"] = $dong_data;

		// 	echo json_encode($response);

		// 	break;

		case "chart":
			break;
	}
?>