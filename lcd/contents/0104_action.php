<?

include_once("../../common/php_module/common_func.php");

	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$code = $_REQUEST["cmCode"];
		$id = explode("_", $code)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	}

	switch($oper){
		case "get_buffer":
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
				$extra["extra_out_wind"] = 		sprintf('%0.1f', $select_data[0]["soWindSpeed"]);

				$direction = sprintf('%d', $select_data[0]["soWindDirection"]);

				switch($direction){
					case 0:
					case 360:
						$direction = "북풍";
						break;
					case 45:
						$direction = "북동풍";
						break;
					case 90:
						$direction = "동풍";
						break;
					case 135:
						$direction = "남동풍";
						break;
					case 180:
						$direction = "남풍";
						break;
					case 225:
						$direction = "남서풍";
						break;
					case 270:
						$direction = "서풍";
						break;
					case 315:
						$direction = "북서풍";
						break;
				}
				$extra["extra_out_direction"] = $direction;

			}

			$response["extra"] = $extra;

			echo json_encode($response);

			break;

		case "get_today":
		case "get_all":
			$result = get_outsensor_history($code, $oper);

			$response["chart_temp_humi"] = 	$result["chart_temp_humi"];
			$response["chart_gas"] = 		$result["chart_gas"];
			$response["chart_dust"] = 		$result["chart_dust"];
			$response["chart_wind"] = 		$result["chart_wind"];
			$response["table_temp_humi"] = 	$result["table_temp_humi"];
			$response["table_gas"] = 		$result["table_gas"];
			$response["table_dust"] = 		$result["table_dust"];
			$response["table_wind"] = 		$result["table_wind"];

			echo json_encode($response);
			break;
	}
?>