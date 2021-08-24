<?
	include_once("../common/common_func.php");
	include_once("../common/common_mongodb.php");

	$response=array();	//응답 JSON array

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $cmCode)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	}

	switch($oper){

		//입추 + 출하판단 및 일령판단
		case "chkInOut":

			//계정이 있는지 여부 판단
			$select_query = "SELECT * FROM farm_detail WHERE fdFarmid='$farmID' AND fdDongid='$dongID'";
			$select_data  = get_select_data($select_query);

			if(count($select_data)>=1){
				$response["chkAccount"]="Y";
				$summary_farm_name = $select_data[0]["fdName"];	  //농장명
				$summary_gpslat	   = $select_data[0]["fdGpslat"]; //GPS-lat
				$summary_gpslng	   = $select_data[0]["fdGpslng"]; //GPS-lng

				//요약정보
				$select_query = "SELECT *,IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM
								FROM comein_master,buffer_sensor_status
								WHERE cmFarmid=beFarmid AND cmDongid=beDongid AND IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4 AND cmFarmid='$farmID' AND cmDongid='$dongID'";
				$select_data = get_select_data($select_query);
				
				if(count($select_data)>=1){
					$response["chk_inout_state"]="입추";
					$response["cmCode"] = $select_data[0]["cmCode"]; //입추코드
					$cmCode=$select_data[0]["cmCode"]; //입추코드

					//==== 상단부분==========================================================================
					//어제 마지막꺼 정보 가져오기
					$toDay = date("Y-m-d");
					$yesterDay = date("Y-m-d",strtotime("-1 Days"));
					// $select_query="SELECT * , IFNULL(DATEDIFF(DATE_SUB(current_date(), INTERVAL 1 Day),cmIndate)+1,0) as inTERM 
					// 			FROM avg_weight,comein_master
					// 			WHERE awFarmid=cmFarmid AND awDongid=cmDongid AND cmCode='" . $cmCode . "' AND LEFT(awDate,10)='" . $yesterDay . "'
					// 			ORDER BY awDate DESC LIMIT 0,1";

					$select_query = "SELECT aw.*, cm.*, IFNULL(DATEDIFF(aw.awDate, cmIndate) + 1, 0) AS inTERM FROM
								(SELECT awFarmid, awDongid, MAX(awDate) AS maxDate
									FROM avg_weight WHERE awFarmid = \"" . $farmID . "\" AND awDongid = \"" . $dongID . "\" AND 
									awDate BETWEEN \"" . $yesterDay . " 00:00:00\" AND \"" . $toDay . " 23:59:00\"
									GROUP BY awFarmid, awDongid, LEFT(awDate, 10) ORDER BY maxDate DESC) AS maw
								JOIN avg_weight AS aw ON aw.awFarmid = maw.awFarmid AND aw.awDongid = maw.awDongid AND aw.awDate = maw.maxDate
								JOIN comein_master AS cm ON cmCode = \"" . $cmCode . "\";";

					$select_data = get_select_data($select_query);

					// 2021-04-27 이병선 오늘 실시간 추가
					// $select_data[0]은 현재 데이터, $select_data[1]은 어제 마지막 데이터

					$curr_interm = $select_data[0]["inTERM"];	//현재 일령
					$curr_weight = $select_data[0]["awWeight"];	//현재 평균중량
					$curr_devi 	 = $select_data[0]["awDevi"];	//현재 표준편차

					$prev_weight = $select_data[1]["awWeight"];	//어제 평균중량
					$prev_esti1  = $select_data[1]["awEstiT1"];	//어제 +1 예측
					$prev_esti2  = $select_data[1]["awEstiT2"];	//어제 +2 예측
					$prev_esti3  = $select_data[1]["awEstiT3"];	//어제 +3 예측
					$prev_date   = $select_data[1]["awDate"];	//어제 마지막 산출 시간

					if($curr_interm > 15){
						$prev_avg_inc_2 = $prev_esti2 - $prev_esti1;
						$prev_avg_inc_3 = $prev_esti3 - $prev_esti2;

						if($curr_weight < $prev_weight){
							$curr_weight = $prev_weight;
						}

					}
					else{
						$prev_weight = "0.0";
						$prev_esti1 = "0.0";
						$prev_esti2 = "0.0";
						$prev_esti3 = "0.0";

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
						//표준편차 * 2.28 추가(2020-11-04)
						$curr_min_weight = sprintf('%0.1f', $curr_weight - ($curr_devi * corr_devi) );
						$curr_max_weight = sprintf('%0.1f', $curr_weight + ($curr_devi * corr_devi) );
					}


					//요약정보===============================
					$summary=array(
						"summary_farm_name" => $summary_farm_name ,								/*농장명*/
						"summary_gpslat"    => $summary_gpslat,									/*GPS-Lat*/
						"summary_gpslng"    => $summary_gpslng,									/*GPS-Lng*/

						"summary_indate"    => substr($select_data[0]["cmIndate"], 0, 10),		/*입추일자*/ 
						"summary_interm"    => $select_data[0]["inTERM"],						/*현재 일령*/ 
						"summary_inType"    => $select_data[0]["cmIntype"],						/*입추형식-육계,토종계,삼계,산란계*/
						"summary_insu"      => $select_data[0]["cmInsu"],						/*입추수량*/
						"summary_avg_weight"=> sprintf('%0.1f', $curr_weight),					/*실시간 평균중량*/
						"summary_devi"      => sprintf('%0.1f', $curr_devi * corr_devi),		/*실시간 표준편차*/
						"summary_vc"        => sprintf('%0.1f', $select_data[0]["awVc"]),		/*실시간 변이계수*/
		
						"summary_min_avg_weight"	=>  $curr_min_weight,						/*실시간 min 평체*/
						"summary_curr_avg_wWeight"	=>  sprintf('%0.1f', $curr_weight),			/*실시간 평균중량*/
						"summary_max_avg_weight"	=>  $curr_max_weight,						/*실시간 max 평체*/

						"summary_day_term1"		=>  ($curr_interm - 1) . "일령",				/*어제 일령*/
						"summary_day_term2"		=>  ($curr_interm + 1) . "일령",				/*내일 일령*/
						"summary_day_term3"		=>  ($curr_interm + 2) . "일령",				/*모레 일령*/

						"summary_day1"			=>  sprintf('%0.1f', $prev_weight),				/*어제 예측평체*/
						"summary_day2"			=>  sprintf('%0.1f', $prev_esti2),				/*내일 예측평체*/
						"summary_day3"			=>  sprintf('%0.1f', $prev_esti3),				/*모레 예측평체*/

						"summary_day_inc1"		=> $prev_date,									/*어제 마지막 평균중량 산출 시간*/
						"summary_day_inc2"		=> sprintf('%0.1f', $prev_avg_inc_2),			/*2일차 중량증가량*/
						"summary_day_inc3"		=> sprintf('%0.1f', $prev_avg_inc_3),			/*1일차 중량증가량*/
					);
					$response["summary"] = $summary;


					//현재 센서별 4단계(정상,주의,경고,위험) 정보 가져오기
					$select_data=array();
					$select_query="SELECT * , IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM 
							 FROM comein_master,buffer_sensor_status
							 WHERE cmFarmid=beFarmid AND cmDongid=beDongid AND cmCode='" . $cmCode . "'";
					$select_data=get_select_data($select_query);

					$curr_avg_temp_alert = sensorLevel($select_data[0]["cmIntype"],'온도',$select_data[0]["inTERM"],$select_data[0]["beAvgTemp"]-1.2 ,localDB_Conn);
					$curr_avg_humi_alert = sensorLevel($select_data[0]["cmIntype"],'습도',$select_data[0]["inTERM"],$select_data[0]["beAvgHumi"]+7   ,localDB_Conn);
					$curr_avg_co2_alert  = sensorLevel($select_data[0]["cmIntype"],'CO2',$select_data[0]["inTERM"],$select_data[0]["beAvgCo2"],localDB_Conn);
					$curr_avg_nh3_alert  = sensorLevel($select_data[0]["cmIntype"],'NH3',$select_data[0]["inTERM"],$select_data[0]["beAvgNh3"],localDB_Conn);

					//현재 센서별 평균정보====================
					$avgData=array(
						"curr_avg_temp" => sprintf('%0.1f',$select_data[0]["beAvgTemp"]-1.2),
						"curr_avg_humi" => sprintf('%0.1f',$select_data[0]["beAvgHumi"]+7),
						"curr_avg_co2"  => sprintf('%0.1f',$select_data[0]["beAvgCo2"]),
						"curr_avg_nh3"  => sprintf('%0.1f',$select_data[0]["beAvgNh3"]),
						"curr_avg_temp_alert" => $curr_avg_temp_alert,
						"curr_avg_humi_alert" => $curr_avg_humi_alert,
						"curr_avg_co2_alert"  => $curr_avg_co2_alert,
						"curr_avg_nh3_alert"  => $curr_avg_nh3_alert
					);
					$response["curr_avg_data"] = $avgData;
				}
				else{
					$response["chkInOutState"] = "출하";

					//요약정보===============================
					$summary=array(
						"summary_farm_name" => $summary_farm_name,	/*농장명*/
						"summary_indate"    => "0000-00-00",		/*입추일자*/
						"summary_interm"    => 0,					/*오늘일령*/
						"summary_inType"    => "",					/*입추형식-육계,토종계,삼계,산란계*/
						"summary_gps_lat"   => $summary_gpslat,		/*GPS-Lat*/
						"summary_gps_lng"   => $summary_gpslng,		/*GPS-Lng*/
						"summary_avg_weight"=> 0,					/*현재 평균중량*/
						"summary_devi"      => 0,					/*현재 표준편차*/
						"summary_vc"        => 0					/*변이계수*/
					);
					$response["summary"]=$summary;


					//현재 센서별 평균정보====================
					$avgData=array(
						"curr_avg_temp" => 0,
						"curr_avg_humi" => 0,
						"curr_avg_co2"  => 0,
						"curr_avg_nh3"  => 0
					);
					$response["curr_avg_data"]=$avgData;
				}

			}
			else{
				$response["chkAccount"] = "N";
			}
			break;

		case "change_intype":
			$PK=check_str($_REQUEST["code"]); //입추코드
			$fieldArr["cmIntype"]=check_str($_REQUEST["change_intype"]); //입추구분
			
			excuteQuery("UPDATE","comein_master",$fieldArr,"cmCode=\"$PK\"" ,localDB_Conn);
			$response["summary_intype"]=$fieldArr["cmIntype"];
			break;
			
		case "page_01":
			$farmID=check_str($_REQUEST["farmID"]);
			$dongID=check_str($_REQUEST["dongID"]);
			$sensorType=check_str($_REQUEST["sensorType"]);
			$cmCode=check_str($_REQUEST["cmCode"]);

			//메인 Query
			$select_query="SELECT * , IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM 
					 FROM comein_master,buffer_sensor_status
					 WHERE cmFarmid=beFarmid AND cmDongid=beDongid AND cmCode='" . $cmCode . "'";
			$select_data=get_select_data($select_query,localDB_Conn);


			//각 저울별 센서 Data값 가져오기==============
			$currSensor=array(
				"currWeight_01" => sprintf('%0.1f',$select_data[0]["beWeight_01"]), "currTemp_01" => sprintf('%0.1f',$select_data[0]["beTemp_01"]-1.2), "currHumi_01" => sprintf('%0.1f',$select_data[0]["beHumi_01"]+7), "currCO2_01" => sprintf('%0.1f',$select_data[0]["beCo2_01"]), "currNH3_01" => sprintf('%0.1f',$select_data[0]["beNh3_01"]),
				"currWeight_02" => sprintf('%0.1f',$select_data[0]["beWeight_02"]), "currTemp_02" => sprintf('%0.1f',$select_data[0]["beTemp_02"]-1.2), "currHumi_02" => sprintf('%0.1f',$select_data[0]["beHumi_02"]+7), "currCO2_02" => sprintf('%0.1f',$select_data[0]["beCo2_02"]), "currNH3_02" => sprintf('%0.1f',$select_data[0]["beNh3_02"]),
				"currWeight_03" => sprintf('%0.1f',$select_data[0]["beWeight_03"]), "currTemp_03" => sprintf('%0.1f',$select_data[0]["beTemp_03"]-1.2), "currHumi_03" => sprintf('%0.1f',$select_data[0]["beHumi_03"]+7), "currCO2_03" => sprintf('%0.1f',$select_data[0]["beCo2_03"]), "currNH3_03" => sprintf('%0.1f',$select_data[0]["beNh3_03"])
			);
			$response["currSensor"]=$currSensor;


			//일령별 평균중량 변화추이
			$retArr=avgWeight($cmCode,$sensorType,"ALLDAY",localDB_Conn);
			$response["alldayChart"]=$retArr["chart_arr"];

			$alldayTable=$retArr["chart_table"];
			if(count($alldayTable)>0){
				array_multisort(array_column($alldayTable, 'f1') , SORT_DESC, $alldayTable); //$dayWeightTable sort ==> DESC
			}
			$response["alldayTable"]=$alldayTable;
			break;

		case "page_02":
			$farmID=check_str($_REQUEST["farmID"]);
			$dongID=check_str($_REQUEST["dongID"]);
			$sensorType=check_str($_REQUEST["sensorType"]);
			$cmCode=check_str($_REQUEST["cmCode"]);

			//메인 Query
			$select_query="SELECT * , IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM 
					 FROM comein_master,buffer_sensor_status
					 WHERE cmFarmid=beFarmid AND cmDongid=beDongid AND cmCode='" . $cmCode . "'";
			$select_data=get_select_data($select_query);

			//오늘 평균중량 변화추이
			$retArr=avgWeight($cmCode,$sensorType,"TODAY",localDB_Conn);
			$response["todayChart"]=$retArr["chart_arr"];

			//일령별 평균중량 변화추이
			$retArr=avgWeight($cmCode,$sensorType,"ALLDAY",localDB_Conn);
			$response["alldayChart"]=$retArr["chart_arr"];

			$alldayTable=$retArr["chart_table"];
			if(count($alldayTable)>0){
				array_multisort(array_column($alldayTable, 'f1') , SORT_DESC, $alldayTable); //$dayWeightTable sort ==> DESC
			}
			$response["alldayTable"]=$alldayTable;
			break;

		case "environment_sensor":
			$farmID=check_str($_REQUEST["farmID"]);
			$dongID=check_str($_REQUEST["dongID"]);
			$sensorType=check_str($_REQUEST["sensorType"]);
			$cmCode=check_str($_REQUEST["cmCode"]);

			//오늘 환경센서 변화추이
			$retArr=avgEnvironment($cmCode,$sensorType,"TODAY",localDB_Conn,$mongoDB);
			$response["today_chart"]=$retArr["chart_arr"];

			//일령별 환경센서 변화추이
			$retArr=avgEnvironment($cmCode,$sensorType,"ALLDAY",localDB_Conn,$mongoDB);
			$response["alldayChart"]=$retArr["chart_arr"];

			$alldayTable=$retArr["chart_table"];
			if(count($alldayTable)>0){
				array_multisort(array_column($alldayTable, 'f1') , SORT_DESC, $alldayTable); //$alldaySensorTable sort ==> DESC
			}
			$response["alldayTable"]=$alldayTable;
			break;
	}

	echo json_encode($response);

?>