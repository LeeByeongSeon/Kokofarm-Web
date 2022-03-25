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

			// 농장 데이터
			$select_sql = "SELECT be.*, sl.*, sf.*, cm.*, f.*, IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS inTerm FROM buffer_sensor_status AS be 
						JOIN farm AS f ON f.fFarmid = be.beFarmid 
						LEFT JOIN comein_master AS cm ON cm.cmFarmid = be.beFarmid AND cm.cmDongid = be.beDongid AND cm.cmCode = be.beComeinCode 
						LEFT JOIN set_light AS sl ON sl.slFarmid = be.beFarmid AND sl.slDongid = be.beDongid 
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = be.beFarmid AND sf.sfDongid = be.beDongid 
						LEFT JOIN farm_detail AS fd ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid 
						WHERE beFarmid = \"" .$farmID. "\"" ;

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

			// 사육관련
			$comein_count = 0;	//생존수
			$death_count = 0;	//폐사
			$cull_count = 0;	//도태
			$thinout_count = 0;	//솎기

			foreach($buffer_data as $row){

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

				$comein_count += $row["cmInsu"];
				$death_count += $row["cmDeathCount"];
				$cull_count += $row["cmCullCount"];
				$thinout_count += $row["cmThinoutCount"];

				$feed_max += $row["sfFeedMax"];
				$feed_remain += $row["sfFeed"];
			}

			$dong_count = count($buffer_data);

			$summary["summary_farm_weight"] = sprintf('%0.1f', $farm_weight / $dong_count);				// 전체 평균중량
			$summary["summary_farm_devi"] = sprintf('%0.1f', ($farm_devi * corr_devi) / $dong_count);	// 전체 표준편차
			$summary["summary_farm_vc"] = sprintf('%0.1f', $farm_vc / $dong_count);						// 전체 변이계수

			// 동별 편차 구하기
			$t = 0;
			for($i=0; $i<$dong_count; $i++){
				$b = $summary["summary_farm_weight"] - $weight_arr[$i];
				$t += pow($b, 2);
			}
			$farm_diff = $t / $dong_count;
			$farm_diff = sprintf('%0.1f', sqrt($farm_diff));	

			$summary["summary_farm_diff"] = $farm_diff;						// 동별 표준편차

			$percent = $feed_remain / $feed_max;
			$percent = round($percent * 100);
			$summary["summary_feed_percent"] = $percent . "%";
			$summary["summary_feed_remain"] = $feed_remain;

			$summary["summary_curr_feed"] = $curr_feed;
			$summary["summary_prev_feed"] = $prev_feed;
			$summary["summary_all_feed"] = $all_feed;

			$summary["summary_curr_water"] = $curr_water;
			$summary["summary_prev_water"] = $prev_water;
			$summary["summary_all_water"] = $all_water;

			$summary["summary_comein_count"] = $comein_count;
			$summary["summary_death_count"] = $death_count;
			$summary["summary_cull_count"] = $cull_count;
			$summary["summary_thinout_count"] = $thinout_count;

			$summary["farm_name"] = $buffer_data[0]["fName"];
			$summary["dong_count"] = $dong_count;

			$response["summary"] = $summary;

			echo json_encode($response);

			break;

		case "chart":
			break;
	}
?>