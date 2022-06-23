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
		case "get_buffer":
			
			$now = date("Y-m-d H:i:s");
			$time_1 = date("Y-m-d H:i:s", strtotime("-1 hours"));

			// 농장 데이터
			$select_sql = "SELECT be.*, sl.*, sf.*, cm.*, f.*, sh.*, 
						IFNULL(DATEDIFF(IF(cm.cmOutdate is null, current_date(), cm.cmOutdate), cm.cmIndate) + 1, 0) AS inTerm FROM buffer_sensor_status AS be 
						JOIN farm AS f ON f.fFarmid = be.beFarmid 
						LEFT JOIN comein_master AS cm ON cm.cmFarmid = be.beFarmid AND cm.cmDongid = be.beDongid AND cm.cmCode = be.beComeinCode 
						LEFT JOIN set_light AS sl ON sl.slFarmid = be.beFarmid AND sl.slDongid = be.beDongid 
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = be.beFarmid AND sf.sfDongid = be.beDongid 
						LEFT JOIN farm_detail AS fd ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid 
						LEFT JOIN sensor_history AS sh ON sh.shFarmid = be.beFarmid AND sh.shDongid = be.beDongid AND shDate = \"" . substr($time_1, 0, 13) . ":00:00\" 
						WHERE beFarmid = \"" .$farmID. "\" ORDER BY cmDongid DESC" ;

			$buffer_data = get_select_data($select_sql);

			// echo json_encode($buffer_data);

			$summary = array();
			
			// 평균중량
			$farm_weight = 0;
			$farm_devi = 0;
			$farm_vc = 0;

			// 동별 편차
			$weight_arr = array();
			$farm_diff = 0;

			// 급이량
			$curr_feed = 0;
			$prev_feed = 0;
			$all_feed = 0;

			// 급수량
			$curr_water = 0;
			$prev_water = 0;
			$all_water = 0;

			$water_per_hour = 0;

			// 사육관련
			$comein_count = 0;	//생존수
			$death_count = 0;	//폐사
			$cull_count = 0;	//도태
			$thinout_count = 0;	//솎기

			// 그래프 데이터
			$feed_chart = array();
			$water_chart = array();
			$weight_chart = array();

			// 사료빈 유무 확인
			$set_feeder_id = "";

			// 일령별로 동 묶기위한 배열
			$day_arr = array();

			foreach($buffer_data as $row){

				$day_arr[$row["inTerm"]] = isset($day_arr[$row["inTerm"]]) ? $day_arr[$row["inTerm"]] + 1 : 1;

				$set_feeder_id .= $row["sfDongid"];

				$weight_arr[] = $row["beAvgWeight"];
 
				$farm_weight += $row["beAvgWeight"];
				$farm_devi += $row["beDevi"];
				$farm_vc += $row["beVc"];

				$curr_feed += $row["sfDailyFeed"];
				$prev_feed += $row["sfPrevFeed"];
				$all_feed += $row["sfAllFeed"];
				
				$curr_water += $row["sfDailyWater"];
				$prev_water += $row["sfPrevWater"];
				$all_water += $row["sfAllWater"];

				$comein_count += $row["cmInsu"] + $row["cmExtraSu"];
				$extra_count += $row["cmExtraSu"];
				$death_count += $row["cmDeathCount"];
				$cull_count += $row["cmCullCount"];
				$thinout_count += $row["cmThinoutCount"];

				$feed_max += $row["sfFeedMax"];
				$feed_remain += $row["sfFeed"];

				$feed_json = json_decode($row["shFeedData"]);
				$water_per_hour += $feed_json->feed_water;

				$weight_chart[] = array(
					"동" => $row["beDongid"] ."동",
					"평균중량" => $row["beAvgWeight"],
				);

				$feed_chart[] = array(
					"동" => $row["beDongid"] ."동",
					"급이량" => $row["sfDailyFeed"],
				);

				$water_chart[] = array(
					"동" => $row["beDongid"] ."동",
					"급수량" => $row["sfDailyWater"],
				);
			}

			$dong_count = count($buffer_data);
			$interm_info = "";
			foreach($day_arr as $key => $val){
				$interm_info .= "<span class='font-sm badge bg-orange'>" . $key . "일령(" . $val . "개동) </span> &nbsp";
			}

			$all_farm_devi = sprintf('%0.1f', ($farm_devi * corr_devi) / $dong_count);

			$summary["summary_farm_weight"] = sprintf('%0.1f', $farm_weight / $dong_count);					  // 전체 평균중량
			$summary["summary_min_weight"] = sprintf('%0.1f', ($farm_weight / $dong_count) - $all_farm_devi); // 최소 평균중량
			$summary["summary_max_weight"] = sprintf('%0.1f', ($farm_weight / $dong_count) + $all_farm_devi); // 최대 평균중량
			// $summary["summary_farm_devi"] = sprintf('%0.1f', ($farm_devi * corr_devi) / $dong_count);	  // 전체 표준편차
			// $summary["summary_farm_vc"] = sprintf('%0.1f', $farm_vc / $dong_count);						  // 전체 변이계수

			// 동별 편차 구하기
			$t = 0;
			for($i=0; $i<$dong_count; $i++){
				$b = $summary["summary_farm_weight"] - $weight_arr[$i];
				$t += pow($b, 2);
			}
			$farm_diff = $t / $dong_count;
			$farm_diff = sprintf('%0.1f', sqrt($farm_diff));	

			$summary["summary_farm_diff"] = $farm_diff;						// 동별 표준편차

			if($feed_remain > 0){
				$percent = $feed_remain / $feed_max;
			}
			$percent = round($percent * 100);
			$summary["summary_feed_percent"] = $percent . "%";
			$summary["summary_feed_remain"] = $feed_remain;

			$summary["summary_curr_feed"] = $curr_feed;
			$summary["summary_prev_feed"] = $prev_feed;
			$summary["summary_all_feed"] = $all_feed;

			$summary["summary_curr_water"] = $curr_water;
			$summary["summary_prev_water"] = $prev_water;
			$summary["summary_all_water"] = $all_water;

			$summary["summary_water_per_hour"] = $water_per_hour;

			$summary["summary_comein_count"] = $comein_count;
			$summary["summary_extra_count"] = $extra_count;
			$summary["summary_live_count"] = $comein_count - $death_count - $cull_count - $thinout_count;
			$summary["summary_live_percent"] = sprintf('%0.1f', ($summary["summary_live_count"] / $comein_count) * 100);	
			$summary["summary_death_count"] = $death_count;
			$summary["summary_cull_count"] = $cull_count;
			$summary["summary_thinout_count"] = $thinout_count;

			$summary["farm_name"] = $buffer_data[0]["fName"];
			$summary["dong_count"] = $interm_info;

			$response["summary"] = $summary;
			$response["weight_chart"] = $weight_chart;
			$response["feed_chart"] = $feed_chart;
			$response["water_chart"] = $water_chart;

			$response["set_feeder_id"] = $set_feeder_id;

			echo json_encode($response);

			break;

		case "get_feed_per_count":
			$select_sql = "SELECT fe.*, cd.* FROM (
							SELECT sh.shFarmid, sh.shDongid, LEFT(shDate, 10) AS shDate, 
								SUM(JSON_EXTRACT(shFeedData, \"$.feed_feed\")) AS feed, SUM(JSON_EXTRACT(shFeedData, \"$.feed_water\")) AS water, 
								cm.cmCode, cm.cmInsu, cm.cmExtraSu, cm.cmAlreadyFeed, LEFT(cm.cmIndate, 10) AS cmIndate 
							FROM buffer_sensor_status AS be 
							LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode 
							LEFT JOIN sensor_history AS sh ON sh.shFarmid = be.beFarmid AND sh.shDongid = be.beDongid AND sh.shDate 
								BETWEEN cm.cmIndate AND IF(cm.cmOutdate is null, now(), cm.cmOutdate)
							WHERE be.beFarmid = \"" .$farmID. "\" GROUP BY cm.cmCode, shFarmid, shDongid, LEFT(shDate, 10)
							) AS fe
							LEFT JOIN comein_detail AS cd ON cd.cdCode = fe.cmCode AND cd.cdDate = shDate";

			$feed_data = get_select_data($select_sql);

			$select_sql = "SELECT * FROM fcr_info WHERE fiType = \"cobb500\"";
			$f_data = get_select_data($select_sql);
			$fcr_table = array();

			foreach($f_data as $row){
				$fcr_table[$row["fiDay"]] = $row["fiFcr"];
			}

			$dong_per_feed = array();
			$dong_per_water = array();
			$dong_in = array();
			$dong_out = array();

			// 전체 농장별로 구하기 위한 날짜별 배열
			$daily_feed_data = array();
			
			foreach($feed_data as $row){

				$date = $row["shDate"];

				if(!array_key_exists($date, $daily_feed_data)){
					$daily_feed_data[$date] = array();
				}

				$daily_feed_data[$date][$row["shDongid"]] = $row;

				// 동별 계산
				$key = $row["shDongid"];

				if(!array_key_exists($key, $dong_per_feed)){
					$dong_per_feed[$key] = 0;
					$dong_per_water[$key] = 0;
					$dong_in[$key] = $row["cmInsu"] + $row["cmExtraSu"];
					$dong_out[$key] = 0;
				}

				// 입추 전 사료 투입량
				if($date == $row["cmIndate"]){
					$feed += $row["cmAlreadyFeed"] * 1000;
				}

				$feed = $row["feed"] * 1000;  // g으로 단위 환산
				$water = $row["water"];  // 

				$live = $dong_in[$key] - $dong_out[$key];

				$per_feed = $feed / $live;
				$per_water = $water / $live;
				$dong_per_feed[$key] += $per_feed;
				$dong_per_water[$key] += $per_water;

				//echo($key . " live : " . $live . " out : " . $dong_out[$key] . " per_feed : " . $per_feed . "\n");

				$dong_out[$key] += $row["cdDeath"] + $row["cdCull"] + $row["cdThinout"];
			}

			// 전체 농장 합산 계산
			$total_per_feed = 0;
			$total_per_water = 0;
			$total_in = 0;
			$total_out = 0;

			$interm = 0;

			foreach($daily_feed_data as $date => $date_data){

				$interm++;

				if($total_in == 0){
					foreach($date_data as $row){
						$total_in += $row["cmInsu"] + $row["cmExtraSu"];
					}
				}

				$feed = 0;
				$water = 0;
				$out = 0;

				foreach($date_data as $row){

					if($date == $row["cmIndate"]){
						$feed += $row["cmAlreadyFeed"] * 1000;
					}

					$feed += $row["feed"] * 1000;
					$water += $row["water"];
					$out += $row["cdDeath"] + $row["cdCull"] + $row["cdThinout"];
				}

				$live = $total_in - $total_out;
				$per_feed = $feed / $live;
				$per_water = $water / $live;

				$total_per_feed += $per_feed;
				$total_per_water += $per_water;

				//echo(" live : " . $live . " out : " . $total_out . " per_feed : " . $per_feed . " per_water : " . $per_water ."\n");

				$total_out += $out;

			}

			$interm = $interm <= 60 ? $interm : 60;

			if($interm > 15){
				$response["total_fcr_weight"] = sprintf('%0.1f', $total_per_feed / $fcr_table[$interm]);
				$response["total_fcr"] = sprintf('%0.3f', $fcr_table[$interm]);
			}
			else{
				$response["total_fcr_weight"] = " - ";
				$response["total_fcr"] = " - ";
			}

			$response["total_per_feed"] = sprintf('%0.1f', $total_per_feed);	
			$response["total_per_water"] = sprintf('%0.3f', $total_per_water);	
			$response["dong_per_feed"] = $dong_per_feed;
			$response["dong_per_water"] = $dong_per_water;

			echo json_encode($response);

			break;
	}
?>