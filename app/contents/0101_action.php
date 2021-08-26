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
			$to_day = substr($now, 0, 10);
			$yester_day = date("Y-m-d", strtotime("-1 Days"));

			$day_plus_1 = date("Y-m-d", strtotime("+1 Days"));
			$day_plus_2 = date("Y-m-d", strtotime("+2 Days"));

			// 버퍼 및 입추정보, 카메라 데이터
			$select_sql = "SELECT be.*, sf.*, cm.*, sc.*, so.*, fd.fdName, sh.shFeedData, IFNULL(DATEDIFF(current_date(), cmIndate) + 1, 0) AS inTerm FROM comein_master AS cm
						JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid 
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid 
						LEFT JOIN set_outsensor AS so ON so.soFarmid = cm.cmFarmid AND so.soDongid = cm.cmDongid 
						LEFT JOIN set_camera AS sc ON sc.scFarmid = cm.cmFarmid AND sc.scDongid = cm.cmDongid 
						LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid 
						LEFT JOIN sensor_history AS sh ON sh.shFarmid = cm.cmFarmid AND sh.shDongid = cm.cmDongid AND shDate = \"" . substr($now, 0, 13) . ":00:00\" 
						WHERE cmCode = \"" .$cmCode. "\"";

						//LEFT JOIN request_calculate AS rc ON rc.rcCode = \"" .$cmCode. "\" 

			$buffer_data = get_select_data($select_sql);

			// 어제 및 오늘 평균중량 데이터
			$select_sql = "SELECT aw.* FROM 
								(SELECT awFarmid, awDongid, MAX(awDate) AS maxDate
								FROM avg_weight WHERE awFarmid = \"" .$farmID. "\" AND awDongid = \"" .$dongID. "\" AND 
								awDate BETWEEN \"" .$yester_day. " 00:00:00\" AND \"" .$to_day. " 23:59:00\"
								GROUP BY awFarmid, awDongid, LEFT(awDate, 10) ORDER BY maxDate DESC) AS maw
							JOIN avg_weight AS aw ON aw.awFarmid = maw.awFarmid AND aw.awDongid = maw.awDongid AND aw.awDate = maw.maxDate";

			$aw_data = get_select_data($select_sql);

			$curr_interm = $buffer_data[0]["inTerm"];		 //현재 일령
			$curr_weight = $buffer_data[0]["beAvgWeight"];	 //현재 평균중량
			$curr_devi   = $buffer_data[0]["beDevi"];		 //현재 표준편차

			$daily_water = $buffer_data[0]["sfDailyWater"]; //일일 급수량
			$daily_feed  = $buffer_data[0]["sfDailyFeed"];  //일일 급이량

			$posi = count($aw_data) - 1;

			if($posi > -1){			// 어제 또는 오늘 데이터가 존재하는 경우
				$prev_weight = sprintf('%0.1f', $aw_data[$posi]["awWeight"]);	 //어제 평균중량
				$prev_esti1  = sprintf('%0.1f', $aw_data[$posi]["awEstiT1"]);	 //어제 +1 예측
				$prev_esti2  = sprintf('%0.1f', $aw_data[$posi]["awEstiT2"]);	 //어제 +2 예측
				$prev_esti3  = sprintf('%0.1f', $aw_data[$posi]["awEstiT3"]);	 //어제 +3 예측
				$prev_date   = sprintf('%0.1f', $aw_data[$posi]["awDate"]);	 //어제 마지막 산출 시간
			}
			else{					// 없는 경우
				$prev_weight = 0.0;	 //어제 평균중량
				$prev_esti1  = 0.0;	 //어제 +1 예측
				$prev_esti2  = 0.0;	 //어제 +2 예측
				$prev_esti3  = 0.0;	 //어제 +3 예측
				$prev_date   = "-";	 //어제 마지막 산출 시간
			}

			if($curr_interm > 15){
				$prev_avg_inc_2 = sprintf('%0.1f', $prev_esti2 - $prev_esti1);
				$prev_avg_inc_3 = sprintf('%0.1f', $prev_esti3 - $prev_esti2);

				if($curr_weight < $prev_weight){
					$curr_weight = $prev_weight;
				}
			}
			else{
				$prev_weight = "-";
				$prev_esti1  = "-";
				$prev_esti2  = "-";
				$prev_esti3  = "-";

				$prev_avg_inc_2 = "0.0";
				$prev_avg_inc_3 = "0.0";
			}

			// 1일령인 경우
			if($curr_interm < 2){
				$curr_min_weight = "-";
				$curr_max_weight = "-";
				$prev_date = "-";
			}
			else{
				$curr_min_weight = sprintf('%0.1f', $curr_weight - ($curr_devi * corr_devi) );
				$curr_max_weight = sprintf('%0.1f', $curr_weight + ($curr_devi * corr_devi) );
			}

			$summary = array(
				//"top_interm"			=> $curr_interm,
				//"top_avg"				=> sprintf('%0.1f', $curr_weight)."g",

				"summary_indate"    	=> substr($buffer_data[0]["cmIndate"], 0, 10),	/*입추일자*/ 
				"summary_interm"    	=> $curr_interm,								/*현재 일령*/ 
				"summary_intype"    	=> $buffer_data[0]["cmIntype"]." - ",			/*입추형식-육계,토종계,삼계,산란계*/
				"summary_insu"      	=> $buffer_data[0]["cmInsu"]." 수",				/*입추수량*/
				"summary_avg_weight"	=> sprintf('%0.1f', $curr_weight),				/*실시간 평균중량*/
				"summary_devi"      	=> sprintf('%0.1f', $curr_devi * corr_devi),	/*실시간 표준편차*/
				"summary_vc"        	=> sprintf('%0.1f', $buffer_data[0]["beVc"]),	/*실시간 변이계수*/

				"summary_min_avg_weight"	=>  $curr_min_weight,						/*실시간 min 평체*/
				"summary_curr_avg_weight"	=>  sprintf('%0.1f', $curr_weight),			/*실시간 평균중량*/
				"summary_max_abg_weight"	=>  $curr_max_weight,						/*실시간 max 평체*/

				"summary_date_term1"		=>  substr($yester_day, 5),					/*어제 날짜*/
				"summary_date_term2"		=>  substr($day_plus_1, 5),					/*내일 날짜*/
				"summary_date_term3"		=>  substr($day_plus_2, 5),					/*모레 날짜*/

				"summary_day_term1"		=>  ($curr_interm - 1)."일령",					/*어제 일령*/
				"summary_day_term2"		=>  ($curr_interm + 1)."일령",					/*내일 일령*/
				"summary_day_term3"		=>  ($curr_interm + 2)."일령",					/*모레 일령*/

				"summary_day_1"			=>  $prev_weight,				/*어제 예측평체*/
				"summary_day_2"			=>  $prev_esti2,				/*내일 예측평체*/
				"summary_day_3"			=>  $prev_esti3,				/*모레 예측평체*/

				"summary_day_inc1"		=> $prev_date,									/*어제 마지막 평균중량 산출 시간*/
				"summary_day_inc2"		=> $prev_avg_inc_2,			/*2일차 중량증가량*/
				"summary_day_inc3"		=> $prev_avg_inc_3,			/*1일차 중량증가량*/

				"summary_day_water"		=> $daily_water."L",							/*일일 급수량*/
				"summary_day_feed"		=> $daily_feed."Kg",							/*일일 급이량*/
				
				"summary_avg_temp" 		=> sprintf('%0.1f', $buffer_data[0]["beAvgTemp"] + corr_temp),	/*현재 온도 센서 평균*/
				"summary_avg_humi" 		=> sprintf('%0.1f', $buffer_data[0]["beAvgHumi"] + corr_humi),	/*현재 습도 센서 평균*/
				"summary_avg_co2"  		=> sprintf('%0.1f', $buffer_data[0]["beAvgCo2"] + corr_co2),	/*현재 이산화탄소 센서 평균*/
				"summary_avg_nh3"  		=> sprintf('%0.1f', $buffer_data[0]["beAvgNh3"] + corr_nh3),	/*현재 암모니아 센서 평균*/
			);
			$response["summary"] = $summary;

			$extra = array();
			if($buffer_data[0]["sfFarmid"] != ""){		// 급이 데이터가 있으면
				$extra["extra_curr_feed"] = $buffer_data[0]["sfDailyFeed"];
				$extra["extra_prev_feed"] = $buffer_data[0]["sfPrevFeed"];
				$extra["extra_curr_water"] = $buffer_data[0]["sfDailyWater"];
				$extra["extra_prev_water"] = $buffer_data[0]["sfPrevWater"];
				$extra["extra_feed_remain"] = $buffer_data[0]["sfFeed"];

				$feed_json = json_decode($buffer_data[0]["shFeedData"]);
				$extra["extra_water_per_hour"] = $feed_json->feed_water;

				// 남은 사료빈 용량 확인
				$feed_max = $buffer_data[0]["sfFeedMax"];
				$curr_feed = $buffer_data[0]["sfFeed"];

				$percent = $curr_feed / $feed_max;

				$percent = round($percent * 100);

				$extra["extra_feed_percent"] = $percent . "%";
			}

			if($buffer_data[0]["soFarmid"] != ""){		// 외기 데이터가 있으면
				$extra["extra_out_temp"] = 		sprintf('%0.1f', $buffer_data[0]["soTemp"]);
				$extra["extra_out_humi"] = 		sprintf('%0.1f', $buffer_data[0]["soHumi"]);
				$extra["extra_out_nh3"] = 		sprintf('%0.1f', $buffer_data[0]["soNh3"]);
				$extra["extra_out_h2s"] = 		sprintf('%0.1f', $buffer_data[0]["soH2s"]);
				$extra["extra_out_dust"] = 		sprintf('%0.1f', $buffer_data[0]["soDust"]);
				$extra["extra_out_udust"] = 	sprintf('%0.1f', $buffer_data[0]["soUDust"]);
				$extra["extra_out_wind"] = 		sprintf('%0.1f', $buffer_data[0]["soWindSpeed"]);

				$direction = sprintf('%d', $buffer_data[0]["soWindDirection"]);

				switch($direction){
					case 0:
					case 360:
						$direction = "북";
						break;
					case 45:
						$direction = "북동";
						break;
					case 90:
						$direction = "동";
						break;
					case 135:
						$direction = "남동";
						break;
					case 180:
						$direction = "남";
						break;
					case 225:
						$direction = "남서";
						break;
					case 270:
						$direction = "서";
						break;
					case 315:
						$direction = "북서";
						break;
				}
				$extra["extra_out_direction"] = $direction;
			}

			$response["extra"] = $extra;

			$name = $buffer_data[0]["fdName"];

			// 테스트농장 카메라 임시조치
			if($buffer_data[0]["beIPaddr"] == "220.124.186.151"){ $buffer_data[0]["beIPaddr"] = "221.159.10.251";}
			$img_url = "../common/php_module/camera_func.php?ip=" .$buffer_data[0]["beIPaddr"]. "&port=" .$buffer_data[0]["scPort"]. "&url=" .urlencode($buffer_data[0]["scUrl"]). "&id=" .$buffer_data[0]["scId"]. "&pw=" .$buffer_data[0]["scPw"];
			
			$camera_zone = "<img src='".$img_url."' onError=\" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide();\">
							<img id='cameraIcon' src='../images/play.png' class='fadeIn animated' onClick=\"camera_modal('" .$name. "','" .$img_url. "'); \">";
			
			$response["camera_zone"] = $camera_zone;

			echo json_encode($response);

			break;
	}
?>