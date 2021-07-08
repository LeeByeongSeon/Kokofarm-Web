<?

include_once("../../common/php_module/common_func.php");

	define("corrDevi",1.28);		  //표준편차보정=>초기화는 *1임(곱하기)
	define("corrDayWeightPer",1.5);   //일별 증체중량의 보정값=>초기화는 *1임(곱하기)

	define("corrTemp",-1.2);	//저울-온도보정
	define("corrHumi",7);		//저울-습도보정
	define("corrCo2", 0);		//저울-CO2보정
	define("corrNh3", 0);		//저울-NH3보정

	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $cmCode)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	}

	switch($oper){
		default :
		
			$to_day = date("Y-m-d");
			$yester_day = date("Y-m-d", strtotime("-1 Days"));

			$select_sql = "SELECT aw.*, sf.*, cm.*, be.*, IFNULL(DATEDIFF(aw.awDate, cmIndate) + 1, 0) AS inTERM FROM
						(SELECT awFarmid, awDongid, MAX(awDate) AS maxDate
							FROM avg_weight WHERE awFarmid = \"$farmID \" AND awDongid = \"$dongID\" AND 
							awDate BETWEEN \"".$yester_day." 00:00:00\" AND \"".$to_day." 23:59:00\"
							GROUP BY awFarmid, awDongid, LEFT(awDate, 10) ORDER BY maxDate DESC) AS maw
						JOIN buffer_sensor_status AS be ON be.beFarmid = maw.awFarmid AND be.beDongid = maw.awDongid
						JOIN avg_weight AS aw ON aw.awFarmid = maw.awFarmid AND aw.awDongid = maw.awDongid AND aw.awDate = maw.maxDate
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = maw.awFarmid AND sf.sfDongid = maw.awDongid AND sf.sfFeedDate = maw.maxDate
						JOIN comein_master AS cm ON cmCode = \"$cmCode\"";

			//var_dump($select_sql);

			$get_data = get_select_data($select_sql);

			$curr_interm = $get_data[0]["inTERM"];		 //현재 일령
			$curr_weight = $get_data[0]["awWeight"];	 //현재 평균중량
			$curr_devi   = $get_data[0]["awDevi"];		 //현재 표준편차

			$prev_weight = $get_data[1]["awWeight"];	 //어제 평균중량
			$prev_esti1  = $get_data[1]["awEstiT1"];	 //어제 +1 예측
			$prev_esti2  = $get_data[1]["awEstiT2"];	 //어제 +2 예측
			$prev_esti3  = $get_data[1]["awEstiT3"];	 //어제 +3 예측
			$prev_date   = $get_data[1]["awDate"];		 //어제 마지막 산출 시간

			$daily_water = $get_data[0]["sfDailyWater"]; //일일 급수량
			$daily_feed  = $get_data[0]["sfDailyFeed"];  //일일 급이량

			if(count($get_data) < 2){
				$prev_weight = $get_data[0]["awWeight"];	 //어제 평균중량
				$prev_esti1  = $get_data[0]["awEstiT1"];	 //어제 +1 예측
				$prev_esti2  = $get_data[0]["awEstiT2"];	 //어제 +2 예측
				$prev_esti3  = $get_data[0]["awEstiT3"];	 //어제 +3 예측
				$prev_date   = $get_data[0]["awDate"];		 //어제 마지막 산출 시간
			}

			if($curr_interm > 15){
				$prev_avg_inc_2 = $prev_esti2 - $prev_esti1;
				$prev_avg_inc_3 = $prev_esti3 - $prev_esti2;

				if($curr_weight < $prev_weight){
					$curr_weight = $prev_weight;
				}
			}
			else{
				$prev_weight = "0.0";
				$prev_esti1  = "0.0";
				$prev_esti2  = "0.0";
				$prev_esti3  = "0.0";

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
				$curr_min_weight = sprintf('%0.1f', $curr_weight - ($curr_devi * corrDevi) );
				$curr_max_weight = sprintf('%0.1f', $curr_weight + ($curr_devi * corrDevi) );
			}

			$summary = array(
				"summary_indate"    	=> substr($get_data[0]["cmIndate"], 0, 10),		/*입추일자*/ 
				"summary_interm"    	=> $curr_interm,								/*현재 일령*/ 
				"summary_intype"    	=> $get_data[0]["cmIntype"]." - ",				/*입추형식-육계,토종계,삼계,산란계*/
				"summary_insu"      	=> $get_data[0]["cmInsu"],						/*입추수량*/
				"summary_avg_weight"	=> sprintf('%0.1f', $curr_weight)."g",			/*실시간 평균중량*/
				"summary_devi"      	=> sprintf('%0.1f', $curr_devi * corrDevi),		/*실시간 표준편차*/
				"summary_vc"        	=> sprintf('%0.1f', $get_data[0]["awVc"]),		/*실시간 변이계수*/

				"summary_min_avg_weight"	=>  $curr_min_weight,						/*실시간 min 평체*/
				"summary_curr_avg_weight"	=>  sprintf('%0.1f', $curr_weight)."g",		/*실시간 평균중량*/
				"summary_max_abg_weight"	=>  $curr_max_weight,						/*실시간 max 평체*/

				"summary_day_term1"		=>  ($curr_interm - 1)."일령",					/*어제 일령*/
				"summary_day_term2"		=>  ($curr_interm + 1)."일령",					/*내일 일령*/
				"summary_day_term3"		=>  ($curr_interm + 2)."일령",					/*모레 일령*/

				"summary_day_1"			=>  sprintf('%0.1f', $prev_weight)."g",			/*어제 예측평체*/
				"summary_day_2"			=>  sprintf('%0.1f', $prev_esti2)."g",			/*내일 예측평체*/
				"summary_day_3"			=>  sprintf('%0.1f', $prev_esti3)."g",			/*모레 예측평체*/

				"summary_day_inc1"		=> $prev_date,									/*어제 마지막 평균중량 산출 시간*/
				"summary_day_inc2"		=> sprintf('%0.1f', $prev_avg_inc_2),			/*2일차 중량증가량*/
				"summary_day_inc3"		=> sprintf('%0.1f', $prev_avg_inc_3),			/*1일차 중량증가량*/

				"summary_day_water"		=> $daily_water."L",							/*일일 급수량*/
				"summary_day_feed"		=> $daily_feed."Kg",							/*일일 급이량*/
				
				"curr_avg_temp" 		=> sprintf('%0.1f',$getData[0]["beAvgTemp"] + corrTemp),	/*현재 온도 센서 평균*/
				"curr_avg_humi" 		=> sprintf('%0.1f',$getData[0]["beAvgHumi"] + corrHumi),	/*현재 습도 센서 평균*/
				"curr_avg_co2"  		=> sprintf('%0.1f',$getData[0]["beAvgCo2"] + corrCo2),		/*현재 이산화탄소 센서 평균*/
				"curr_avg_nh3"  		=> sprintf('%0.1f',$getData[0]["beAvgNh3"] + corrNh3),		/*현재 암모니아 센서 평균*/
			);
			$response["summary"] = $summary;
			
			//카메라정보
			$select_camera="SELECT sc.*, be.beIPaddr, fd.fdName FROM set_camera AS sc
							JOIN buffer_sensor_status AS be ON be.beFarmid = sc.scFarmid AND be.beDongid = sc.scDongid
							JOIN farm_detail AS fd ON fd.fdFarmid = sc.scFarmid AND fd.fdDongid = sc.scDongid
							WHERE scFarmid = \"$farmID\" AND scDongid = \"$dongID\"";

			$get_camera = get_select_data($select_camera);

			$name = $get_camera[0]["fdName"];

			$img_url = "../../common/php_module/camera_func.php?ip=" .$get_camera[0]["beIPaddr"]. "&port=" .$get_camera[0]["scPort"]. "&url=" .urlencode($get_camera[0]["scUrl"]). "&id=" .$get_camera[0]["scId"]. "&pw=" .$get_camera[0]["scPw"];
			
			$camera_zone = "<img src='".$img_url."' onError=\" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide();\">
							<img id='cameraIcon' src='../images/play.png' class='fadeIn animated' onClick=\"camera_popup('" .$name. "','" .$img_url. "'); \">";
			
			$response["camera_zone"] = $camera_zone;

			echo json_encode($response);

			break;
	}
?>