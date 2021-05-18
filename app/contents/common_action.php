<?
	include_once("../common/common_func.php");
	//include_once("../common/common_mongodb.php");

	$oper=chkCHAR($_REQUEST["oper"]);

	$response=array();	//응답 JSON array
	$fieldArr=array();

	switch($oper){
		case "chkOutList": //출하목록
			$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
			$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
			$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

			//출하목록
			$strSql="SELECT *,
						   IFNULL((SELECT SUM(cdDeathsu) FROM comein_detail WHERE LEFT(cdCode,21)=cmCode),0) as deathSU,										/*폐사(수)*/
						   IFNULL((cmInsu -  (SELECT IFNULL(SUM(cdDeathsu),0) FROM comein_detail WHERE LEFT(cdCode,21)=cmCode)),0) as remainSU					/*생존(수)*/
					FROM comein_master,farm_detail 
					WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)>=4 AND cmFarmid='$farmID' ORDER BY cmIndate DESC";
			$getData=multiFindData($strSql,localDB_Conn);

			$chkOutTable=array();
			$tmpCount=count($getData)+1;
			foreach($getData as $Val){
				$tmpCount--;
				$chkOutTable[]=array(
					"f1" => $tmpCount,			/*번호*/
					"f2" => $Val["cmCode"],		/*chkInOutCode*/
					"f3" => $Val["cmFarmid"],	/*농장ID*/
					"f4" => $Val["cmDongid"],	/*동ID*/
					"f5" => $Val["fdName"],		/*동명*/
					"f6" => substr($Val["cmIndate"],0,10), /*입추일자*/
					"f7" => substr($Val["cmOutdate"],0,10), /*출하일자*/
					"f8" => $Val["remainSU"] /*생존수*/
				);

			}
			$response["chkOutTable"]=$chkOutTable;
			break;

		case "getWeight":
			$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
			$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
			$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

			//일령별 평균중량 변화추이
			$retArr=avgWeight($chkInOutCode,"평균중량","INOUTDAY",localDB_Conn);
			$response["alldayWeightChart"]=$retArr["chartArr"];

			$alldayWeightTable=$retArr["chartTable"];
			if(count($alldayWeightTable)>0){
				array_multisort(array_column($alldayWeightTable, 'f1') , SORT_DESC, $alldayWeightTable); //$dayWeightTable sort ==> DESC
			}
			$response["alldayWeightTable"]=$alldayWeightTable;
			break;


		case "getSensor": //센서정보 불러오기
			$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]);
			$sensorType=chkCHAR($_REQUEST["sensorType"]);
			$prnType=chkCHAR($_REQUEST["prnType"]);

			switch($prnType){
				case "TODAY":
					$retArr=avgEnvironment($chkInOutCode,$sensorType,"TODAY",localDB_Conn,$mongoDB);
					$response["todaySensorChart"]=$retArr["chartArr"];
					break;
				case "ALLDAY":
					$retArr=avgEnvironment($chkInOutCode,$sensorType,"ALLDAY",localDB_Conn,$mongoDB);
					$response["alldaySensorChart"]=$retArr["chartArr"];

					$alldaySensorTable=$retArr["chartTable"];
					if(count($alldaySensorTable)>0){
						array_multisort(array_column($alldaySensorTable, 'f1') , SORT_DESC, $alldaySensorTable); //$alldaySensorTable sort ==> DESC
					}
					$response["alldaySensorTable"]=$alldaySensorTable;
					break;

				case "INOUTDAY":
					$retArr=avgEnvironment($chkInOutCode,$sensorType,"INOUTDAY",localDB_Conn,$mongoDB);
					$response["inoutdaySensorChart"]=$retArr["chartArr"];

					$inoutdaySensorTable=$retArr["chartTable"];
					if(count($inoutdaySensorTable)>0){
						array_multisort(array_column($inoutdaySensorTable, 'f1') , SORT_DESC, $inoutdaySensorTable); //$inoutdaySensorTable sort ==> DESC
					}
					$response["inoutdaySensorTable"]=$inoutdaySensorTable;	
					break;
			}
			break;

		case "chkOut": //출하화면
			$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
			$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
			$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

			//카메라정보
			$strSql="SELECT *,
							(SELECT beIPaddr FROM buffer_sensor_status WHERE beFarmid=scFarmid AND beDongid=scDongid) as beIPaddr
							FROM set_camera WHERE scFarmid='$farmID' AND scDongid='$dongID' ";
			$getData=multiFindData($strSql,localDB_Conn);
			$cameraURL="../common/camera_func.php?IP=" . $getData[0]["beIPaddr"] . "&PORT=" . $getData[0]["scPort"] . "&URL=" . urlencode($getData[0]["scUrl"]) . "&ID=" . $getData[0]["scId"] . "&PW=" . $getData[0]["scPw"] . "&date=" . date('YmdHis');
			$response["cameraURL"]=$cameraURL;

			break;


		case "chkIN": //입추화면
			$farmID=chkCHAR($_REQUEST["farmID"]);	//농장ID
			$dongID=chkCHAR($_REQUEST["dongID"]);	//동ID
			$chkInOutCode=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드

			//==== 상단부분==========================================================================
			//어제 마지막꺼 정보 가져오기
			$toDay = date("Y-m-d");
			$yesterDay = date("Y-m-d",strtotime("-1 Days"));
			// $strSql="SELECT * , IFNULL(DATEDIFF(DATE_SUB(current_date(), INTERVAL 1 Day),cmIndate)+1,0) as inTERM 
			// 			FROM avg_weight,comein_master
			// 			WHERE awFarmid=cmFarmid AND awDongid=cmDongid AND cmCode='" . $chkInOutCode . "' AND LEFT(awDate,10)='" . $yesterDay . "'
			// 			ORDER BY awDate DESC LIMIT 0,1";

			$strSql = "SELECT aw.*, cm.*, IFNULL(DATEDIFF(aw.awDate, cmIndate) + 1, 0) AS inTERM FROM
						(SELECT awFarmid, awDongid, MAX(awDate) AS maxDate
							FROM avg_weight WHERE awFarmid = \"" . $farmID . "\" AND awDongid = \"" . $dongID . "\" AND 
							awDate BETWEEN \"" . $yesterDay . " 00:00:00\" AND \"" . $toDay . " 23:59:00\"
							GROUP BY awFarmid, awDongid, LEFT(awDate, 10) ORDER BY maxDate DESC) AS maw
						JOIN avg_weight AS aw ON aw.awFarmid = maw.awFarmid AND aw.awDongid = maw.awDongid AND aw.awDate = maw.maxDate
						JOIN comein_master AS cm ON cmCode = \"" . $chkInOutCode . "\";";

			$getData = multiFindData($strSql,localDB_Conn);

			// 2021-04-27 이병선 오늘 실시간 추가
			// $getData[0]은 현재 데이터, $getData[1]은 어제 마지막 데이터

			$curr_interm = $getData[0]["inTERM"];	//현재 일령
			$curr_weight = $getData[0]["awWeight"];	//현재 평균중량
			$curr_devi = $getData[0]["awDevi"];	//현재 표준편차

			$prev_weight = $getData[1]["awWeight"];	//어제 평균중량
			$prev_esti1 = $getData[1]["awEstiT1"];	//어제 +1 예측
			$prev_esti2 = $getData[1]["awEstiT2"];	//어제 +2 예측
			$prev_esti3 = $getData[1]["awEstiT3"];	//어제 +3 예측
			$prev_date = $getData[1]["awDate"];		//어제 마지막 산출 시간

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
				$curr_min_weight = sprintf('%0.1f', $curr_weight - ($curr_devi * corrDevi) );
				$curr_max_weight = sprintf('%0.1f', $curr_weight + ($curr_devi * corrDevi) );
			}

			$summary = array(
				"summaryIndate"   => substr($getData[0]["cmIndate"], 0, 10),			/*입추일자*/ 
				"summaryInterm"   => $getData[0]["inTERM"],								/*현재 일령*/ 
				"summaryInType"   => $getData[0]["cmIntype"],							/*입추형식-육계,토종계,삼계,산란계*/
				"summaryInsu"     => $getData[0]["cmInsu"],								/*입추수량*/
				"summaryAvgWeight"=> sprintf('%0.1f', $curr_weight),					/*실시간 평균중량*/
				"summaryDevi"     => sprintf('%0.1f', $curr_devi * corrDevi),			/*실시간 표준편차*/
				"summaryVc"       => sprintf('%0.1f', $getData[0]["awVc"]),				/*실시간 변이계수*/
 
				"summaryMinAvgWeight"	=>  $curr_min_weight,							/*실시간 min 평체*/
				"summaryCurrAvgWeight"	=>  sprintf('%0.1f', $curr_weight),				/*실시간 평균중량*/
				"summaryMaxAvgWeight"	=>  $curr_max_weight,							/*실시간 max 평체*/

				"summaryDayTerm1"		=>  ($curr_interm - 1) . "일령",				/*어제 일령*/
				"summaryDayTerm2"		=>  ($curr_interm + 1) . "일령",				/*내일 일령*/
				"summaryDayTerm3"		=>  ($curr_interm + 2) . "일령",				/*모레 일령*/

				"summaryDay1"			=>  sprintf('%0.1f', $prev_weight),				/*어제 예측평체*/
				"summaryDay2"			=>  sprintf('%0.1f', $prev_esti2),				/*내일 예측평체*/
				"summaryDay3"			=>  sprintf('%0.1f', $prev_esti3),				/*모레 예측평체*/

				"summaryDayInc1"		=> $prev_date,									/*어제 마지막 평균중량 산출 시간*/
				"summaryDayInc2"		=> sprintf('%0.1f', $prev_avg_inc_2),			/*2일차 중량증가량*/
				"summaryDayInc3"		=> sprintf('%0.1f', $prev_avg_inc_3),			/*1일차 중량증가량*/
			);
			$response["summary"] = $summary;


			//현재 센서별 4단계(정상,주의,경고,위험) 정보 가져오기=============================================
			$getData=array();
			$strSql="SELECT * , IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) as inTERM 
					 FROM comein_master,buffer_sensor_status
					 WHERE cmFarmid=beFarmid AND cmDongid=beDongid AND cmCode='" . $chkInOutCode . "'";
			$getData=multiFindData($strSql,localDB_Conn);

			//온도:-1.2도 습도:+5% 보정 ==> 2020.11.25
			$currAvgTempAlert=sensorLevel($getData[0]["cmIntype"],'온도',$getData[0]["inTERM"],$getData[0]["beAvgTemp"] + corrTemp,	localDB_Conn);
			$currAvgHumiAlert=sensorLevel($getData[0]["cmIntype"],'습도',$getData[0]["inTERM"],$getData[0]["beAvgHumi"] + corrHumi,	localDB_Conn);
			$currAvgCO2Alert =sensorLevel($getData[0]["cmIntype"],'CO2',$getData[0]["inTERM"],$getData[0]["beAvgCo2"] + corrCo2,	localDB_Conn);
			$currAvgNH3Alert =sensorLevel($getData[0]["cmIntype"],'NH3',$getData[0]["inTERM"],$getData[0]["beAvgNh3"] + corrNh3,	localDB_Conn);


			//현재 센서별 평균정보
			$avgData=array(
				"currAvgTemp" => sprintf('%0.1f',$getData[0]["beAvgTemp"] + corrTemp),
				"currAvgHumi" => sprintf('%0.1f',$getData[0]["beAvgHumi"] + corrHumi),
				"currAvgCO2"  => sprintf('%0.1f',$getData[0]["beAvgCo2"] + corrCo2),
				"currAvgNH3"  => sprintf('%0.1f',$getData[0]["beAvgNh3"] + corrNh3),
				"currAvgTempAlert" => $currAvgTempAlert,
				"currAvgHumiAlert" => $currAvgHumiAlert,
				"currAvgCO2Alert" => $currAvgCO2Alert,
				"currAvgNH3Alert" => $currAvgNH3Alert,


				/*화면하단- 1번 저울상태*/
				"currWeight_01" => sprintf('%0.1f',$getData[0]["beWeight_01"]),
				"currTemp_01" => sprintf('%0.1f',$getData[0]["beTemp_01"] + corrTemp),
				"currHumi_01" => sprintf('%0.1f',$getData[0]["beHumi_01"] + corrHumi),
				"currCO2_01" => sprintf('%0.1f',$getData[0]["beCo2_01"] + corrCo2),
				"currNH3_01" => sprintf('%0.1f',$getData[0]["beNh3_01"] + corrNh3),

				/*화면하단- 2번 저울상태*/
				"currWeight_02" => sprintf('%0.1f',$getData[0]["beWeight_02"]),
				"currTemp_02" => sprintf('%0.1f',$getData[0]["beTemp_02"] + corrTemp),
				"currHumi_02" => sprintf('%0.1f',$getData[0]["beHumi_02"] + corrHumi),
				"currCO2_02" => sprintf('%0.1f',$getData[0]["beCo2_02"] + corrCo2),
				"currNH3_02" => sprintf('%0.1f',$getData[0]["beNh3_02"] + corrNh3),

				/*화면하단- 3번 저울상태*/
				"currWeight_03" => sprintf('%0.1f',$getData[0]["beWeight_03"]),
				"currTemp_03" => sprintf('%0.1f',$getData[0]["beTemp_03"] + corrTemp),
				"currHumi_03" => sprintf('%0.1f',$getData[0]["beHumi_03"] + corrHumi),
				"currCO2_03" => sprintf('%0.1f',$getData[0]["beCo2_03"] + corrCo2),
				"currNH3_03" => sprintf('%0.1f',$getData[0]["beNh3_03"] + corrNh3),
			);
			$response["currAvgData"]=$avgData;


			//오늘 평균중량 변화추이==============================================
			//$retArr=avgWeight($chkInOutCode,"평균중량","TODAY",localDB_Conn);
			//$response["todayWeightChart"]=$retArr["chartArr"];

			//오늘 증체중량 변화추이==============================================
			$retArr=avgWeight($chkInOutCode,"증체중량","TODAYINC",localDB_Conn);
			$response["todayIncWeightChart"]=$retArr["chartArr"];

			//일령별 평균중량 변화추이============================================
			$retArr=avgWeight($chkInOutCode,"평균중량","ALLDAY",localDB_Conn);
			$response["alldayWeightChart"]=$retArr["chartArr"];

			$alldayWeightTable=$retArr["chartTable"];
			if(count($alldayWeightTable)>0){
				array_multisort(array_column($alldayWeightTable, 'f1') , SORT_DESC, $alldayWeightTable); //$dayWeightTable sort ==> DESC
			}
			$response["alldayWeightTable"]=$alldayWeightTable;


			//카메라정보========================================================
			$strSql="SELECT *,
							(SELECT beIPaddr FROM buffer_sensor_status WHERE beFarmid=scFarmid AND beDongid=scDongid) as beIPaddr
							FROM set_camera WHERE scFarmid='$farmID' AND scDongid='$dongID' ";
			$getData=multiFindData($strSql,localDB_Conn);
			$cameraURL="../common/camera_func.php?IP=" . $getData[0]["beIPaddr"] . "&PORT=" . $getData[0]["scPort"] . "&URL=" . urlencode($getData[0]["scUrl"]) . "&ID=" . $getData[0]["scId"] . "&PW=" . $getData[0]["scPw"] . "&date=" . date('YmdHis');
			$response["cameraURL"]=$cameraURL;
			break;


		case "request":

			$fieldArr["rcFarmid"] = chkCHAR($_REQUEST["rcFarmid"]); 		//농장 ID
			$fieldArr["rcDongid"] = chkCHAR($_REQUEST["rcDongid"]); 		//동 ID
			$fieldArr["rcRequestDate"] = date("Y-m-d H:i:s"); 				//요청 시간
			$fieldArr["rcCode"] = chkCHAR($_REQUEST["rcCode"]); 			//입추코드
			$fieldArr["rcCommand"] = chkCHAR($_REQUEST["rcCommand"]); 		//산출 명령
			$fieldArr["rcStatus"] = "R";										//작업 상태 (초기는 R (Request))

			$fieldArr["rcPrevLst"] = chkCHAR($_REQUEST["rcPrevLst"]); 		//변경 전 축종
			$fieldArr["rcChangeLst"] = chkCHAR($_REQUEST["rcChangeLst"]); 	//변경 후 축종
			$fieldArr["rcPrevDate"] = chkCHAR($_REQUEST["rcPrevDate"]); 	//변경 전 입추시간
			$fieldArr["rcChangeDate"] = chkCHAR($_REQUEST["rcChangeDate"]); //변경 후 입추시간
			$fieldArr["rcMeasureDate"] = chkCHAR($_REQUEST["rcMeasureDate"]); //실측 시간
			$fieldArr["rcMeasureVal"] = chkCHAR($_REQUEST["rcMeasureVal"]); 	//실측 중량

			excuteQuery("INSERT", "request_calculate", $fieldArr, "" ,localDB_Conn);

			$updateArr = array();
			$updateArr["cmInsu"] = chkCHAR($_REQUEST["tr_count"]);
			excuteQuery("UPDATE", "comein_master", $updateArr, "cmCode=\"" . chkCHAR($_REQUEST["rcCode"]) ."\"" ,localDB_Conn);

			$response["summaryInsu"] = $updateArr["cmInsu"];
			break;

		case "setModal":
			$PK=chkCHAR($_REQUEST["chkInOutCode"]); //입추코드
			
			$strSql="SELECT cmCode, cmIntype, cmIndate, fd.fdName FROM comein_master 
						JOIN farm_detail AS fd ON fd.fdFarmid = cmFarmid AND fd.fdDongid = cmDongid
						WHERE cmCode = \"" .$PK. "\";";
			$getData=multiFindData($strSql,localDB_Conn);

			$response["cmIntype"] = $getData[0]["cmIntype"];
			$response["cmIndate"] = $getData[0]["cmIndate"];
			$response["fdName"] = $getData[0]["fdName"];

			break;

		case "check_request":
			$farmID = chkCHAR($_REQUEST["farmID"]);	//농장ID
			$dongID = chkCHAR($_REQUEST["dongID"]);	//동ID
			$day = chkCHAR($_REQUEST["day"]);	//일령

			$response["status"] = "";
			$response["msg"] = "";
			$response["view_alert"] = false;
			
			$strSql = "SELECT rcStatus, rcRequestDate FROM request_calculate 
					WHERE rcFarmid = \"" . $farmID . "\" AND rcDongid = \"" . $dongID . "\" ORDER BY rcRequestDate DESC LIMIT 1;";

			$getData=multiFindData($strSql,localDB_Conn);

			$rcRequestDate = "";

			if(count($getData) > 0){
				$rcStatus = $getData[0]["rcStatus"];
				$rcRequestDate = $getData[0]["rcRequestDate"];

				$response["status"] = $rcStatus;

				// 상태별 메시지
				switch($rcStatus){
					case "R":	//승인 대기
						$response["msg"] = "요청 승인 대기 중";
						break;
					case "A":	//승인
						$response["msg"] = "승인 후 산출 대기 중";
						break;
					case "J":	//승인 거절
						$response["msg"] = "요청 승인 거절";
						break;
					case "W":	//산출 대기
						$response["msg"] = "승인 후 산출 대기 중";
						break;
					case "C":	//산출 중
						$response["msg"] = "승인 후 재산출 중";
						break;
					case "F":	//산출 완료
						$response["msg"] = "";
						break;
					case "I":	//산출 중단 - 오류
						$response["msg"] = "";
						break;

				}
			}

			// 25, 30 일령에 입력 요청 팝업
			if($day == 25 || $day == 30){
				if(substr($rcRequestDate, 0, 10) != date("Y-m-d")){			// 해당일자에 요청한 데이터가 없는지 확인 
					$response["view_alert"] = true;
				}
			}

			break;

	}

	echo json_encode($response);
?>