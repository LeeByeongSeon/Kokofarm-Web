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
				$time_1 = date("Y-m-d H:i:s", strtotime("-1 hours"));
				$select_sql = "SELECT * FROM set_feeder AS sf
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = sf.sfFarmid AND sh.shDongid = sf.sfDongid AND shDate = \"" . substr($time_1, 0, 13) . ":00:00\" 
							WHERE sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";

				$select_data = get_select_data($select_sql);

				$extra = array();
				if(count($select_data) > 0){		// 사료빈 데이터가 있으면

					$extra["extra_curr_feed"] = $select_data[0]["sfDailyFeed"] < 0 ? 0 : $select_data[0]["sfDailyFeed"];
					$extra["extra_prev_feed"] = $select_data[0]["sfPrevFeed"] < 0 ? 0 : $select_data[0]["sfPrevFeed"];
					$extra["extra_all_feed"] = $select_data[0]["sfAllFeed"] < 0 ? 0 : $select_data[0]["sfAllFeed"];
					$extra["extra_curr_water"] = $select_data[0]["sfDailyWater"] < 0 ? 0 : $select_data[0]["sfDailyWater"];
					$extra["extra_prev_water"] = $select_data[0]["sfPrevWater"] < 0 ? 0 : $select_data[0]["sfPrevWater"];
					$extra["extra_all_water"] = $select_data[0]["sfAllWater"] < 0 ? 0 : $select_data[0]["sfAllWater"];
					$extra["extra_feed_remain"] = $select_data[0]["sfFeed"];

					$feed_json = json_decode($select_data[0]["shFeedData"]);
					$extra["extra_water_per_hour"] = $feed_json->feed_water;

					// 남은 사료빈 용량 확인
					$feed_max = $select_data[0]["sfFeedMax"];
					$curr_feed = $select_data[0]["sfFeed"];
					
					if($curr_feed>0){
						$percent = $curr_feed / $feed_max;
					}
					$percent = round($percent * 100);

					$extra["extra_feed_percent"] = $percent . "%";
				}
				else{
					$extra["extra_curr_feed"] = "-";
					$extra["extra_prev_feed"] = "-";
					$extra["extra_all_feed"] = "-";
					$extra["extra_curr_water"] = "-";
					$extra["extra_prev_water"] = "-";
					$extra["extra_all_water"] = "-";
					$extra["extra_feed_remain"] = "-";

					$extra["extra_water_per_hour"] = "-";

					$extra["extra_feed_percent"] = "-%";;
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
				$response["chart_feed_daily"] = $result["chart_feed_daily"];
				$response["chart_water_daily"] = $result["chart_water_daily"];
				break;
				
			case "get_feed_per_count":

				$select_sql = "SELECT fe.*, cd.* FROM (
									SELECT sh.shFarmid, sh.shDongid, LEFT(shDate, 10) AS shDate, 
									SUM(JSON_EXTRACT(shFeedData, \"$.feed_feed\")) AS feed, SUM(JSON_EXTRACT(shFeedData, \"$.feed_water\")) AS water, cm.cmCode , cmInsu 
									FROM comein_master AS cm 
									LEFT JOIN sensor_history AS sh ON sh.shFarmid = cm.cmFarmid AND sh.shDongid = cm.cmDongid AND sh.shDate 
										BETWEEN cm.cmIndate AND IF(cm.cmOutdate is null, now(), cm.cmOutdate)
									WHERE cm.cmCode = \"". $code ."\" GROUP BY shFarmid, shDongid, LEFT(shDate, 10)
								) AS fe
								LEFT JOIN comein_detail AS cd ON cd.cdCode = fe.cmCode AND cd.cdDate = shDate";
	
				$feed_data = get_select_data($select_sql);
	
				$dong_per_feed = 0;
				$dong_per_water = 0;
				$dong_in = $feed_data[0]["cmInsu"];
				$dong_out = 0;
	
				// 전체 농장별로 구하기 위한 날짜별 배열
				$daily_feed_data = array();
				
				foreach($feed_data as $row){
	
					$feed = $row["feed"] * 1000;  // g으로 단위 환산
					$water = $row["water"];  // 
	
					$live = $dong_in - $dong_out;
	
					$per_feed = $feed / $live;
					$per_water = $water / $live;
					$dong_per_feed += $per_feed;
					$dong_per_water += $per_water;
	
					$dong_out += $row["cdDeath"] + $row["cdCull"] + $row["cdThinout"];
				}
	
				$response["dong_per_feed"] = sprintf('%0.1f', $dong_per_feed);	
				$response["dong_per_water"] = sprintf('%0.3f', $dong_per_water);	
	
				break;
		}

		echo json_encode($response);
	
	};
?>