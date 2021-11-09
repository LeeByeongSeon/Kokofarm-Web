<?

include_once("../common/php_module/common_func.php");
	
	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$code = $_REQUEST["cmCode"];
		$id = explode("_", $code)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);

		switch($oper){
			case "get_buffer":
				$now = date("Y-m-d H:i:s");
				$select_sql = "SELECT * FROM set_feeder AS sf
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = sf.sfFarmid AND sh.shDongid = sf.sfDongid AND shDate = \"" . substr($now, 0, 13) . ":00:00\" 
							WHERE sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";

				$select_data = get_select_data($select_sql);

				$extra = array();
				if(count($select_data) > 0){		// 외기 데이터가 있으면

					$extra["extra_curr_feed"] = $select_data[0]["sfDailyFeed"] < 0 ? 0 : $select_data[0]["sfDailyFeed"];
					$extra["extra_prev_feed"] = $select_data[0]["sfPrevFeed"] < 0 ? 0 : $select_data[0]["sfPrevFeed"];
					$extra["extra_curr_water"] = $select_data[0]["sfDailyWater"] < 0 ? 0 : $select_data[0]["sfDailyWater"];
					$extra["extra_prev_water"] = $select_data[0]["sfPrevWater"] < 0 ? 0 : $select_data[0]["sfPrevWater"];
					$extra["extra_feed_remain"] = $select_data[0]["sfFeed"];

					$feed_json = json_decode($select_data[0]["shFeedData"]);
					$extra["extra_water_per_hour"] = $feed_json->feed_water;

					// 남은 사료빈 용량 확인
					$feed_max = $select_data[0]["sfFeedMax"];
					$curr_feed = $select_data[0]["sfFeed"];

					$percent = $curr_feed / $feed_max;

					$percent = round($percent * 100);

					$extra["extra_feed_percent"] = $percent . "%";
				}

				$response["extra"] = $extra;
				break;

			case "get_today":
				$result = get_feed_history($code, $oper);
				//$response["chart_feed"] = $result["chart_feed_stack"];
				//$response["chart_water"] = $result["chart_water_stack"];
				$response["chart_feed"] = $result["chart_feed"];
				$response["chart_water"] = $result["chart_water"];
				break;
			case "get_all":
				$result = get_feed_history($code, $oper);
				$response["chart_feed"] = $result["chart_feed_daily"];
				$response["chart_water"] = $result["chart_water_daily"];
				break;
		}

		echo json_encode($response);
	
	};
?>