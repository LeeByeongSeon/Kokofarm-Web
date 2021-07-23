<?

include_once("../../common/php_module/common_func.php");

	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $cmCode)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	}

	switch($oper){
		case "get_outsensor":
			$select_sql = "SELECT * FROM set_outsensor WHERE soFarmid = \"" .$farmID. "\" AND soDongid = \"" .$dongID. "\"";

			$select_data = get_select_data($select_sql);

			$extra = array();
			if(count($select_data) > 0){		// 외기 데이터가 있으면
				$extra["extra_out_temp"] = 		sprintf('%0.1f', $select_data[0]["soTemp"]);
				$extra["extra_out_humi"] = 		sprintf('%0.1f', $select_data[0]["soHumi"]);
				$extra["extra_out_nh3"] = 		sprintf('%0.1f', $select_data[0]["soNh3"]);
				$extra["extra_out_h2s"] = 		sprintf('%0.1f', $select_data[0]["soH2s"]);
				$extra["extra_out_dust"] = 		sprintf('%0.1f', $select_data[0]["soDust"]);
				$extra["extra_out_udust"] = 	sprintf('%0.1f', $select_data[0]["soUDust"]);
				$extra["extra_out_direction"] = sprintf('%0.1f', $select_data[0]["soWindDirection"]);
				$extra["extra_out_wind"] = 		sprintf('%0.1f', $select_data[0]["soWindSpeed"]);
			}

			$response["extra"] = $extra;

			echo json_encode($response);

			break;
	}
?>