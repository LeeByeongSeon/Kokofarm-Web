<?

include_once("../common/php_module/common_func.php");

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
				$extra["extra_out_temp"] = 		check_sensor_val('%0.1f', $select_data[0]["soTemp"]);
				$extra["extra_out_humi"] = 		check_sensor_val('%0.1f', $select_data[0]["soHumi"]);
				$extra["extra_out_nh3"] = 		check_sensor_val('%0.1f', $select_data[0]["soNh3"]);
				$extra["extra_out_h2s"] = 		check_sensor_val('%0.1f', $select_data[0]["soH2s"]);
				$extra["extra_out_dust"] = 		check_sensor_val('%0.1f', $select_data[0]["soDust"]);
				$extra["extra_out_udust"] = 	get_udust_status($select_data[0]["soUDust"]);
				$extra["extra_out_wind"] = 		check_sensor_val('%0.1f', $select_data[0]["soWindSpeed"]);
				$extra["extra_out_solar"] = 	check_sensor_val('%0.1f', $select_data[0]["soSolar"]);

				$extra["extra_out_direction"] = get_wind_status($select_data[0]["soWindDirection"]);

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