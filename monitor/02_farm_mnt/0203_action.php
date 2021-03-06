<?

include_once("../common/php_module/common_func.php");
include_once("../common/php_module/socket_func.php");

$mgr_id    = $_SESSION["mgr_id"];
$mgr_name  = $_SESSION["mgr_name"];
$mgr_type  = $_SESSION["mgr_type"];
$mgr_group = $_SESSION["mgr_group"];

if(strlen($mgr_id)<=3 || strlen($mgr_name)<=3 || strlen($mgr_type)<=3 || strlen($mgr_group)<=3){
    echo ("<script>location.href='../00_login/index.php'</script>");
}

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

// cmCode에서 농장, 동 id 추출
if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];
    $id = explode("_", $code)[1];
    $farmID = substr($id, 0, 6);
    $dongID = substr($id, 6);
}

switch($oper){

    case "get_code":
        if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
            $select = $_REQUEST["select"];
            $ids = explode("|", $select);
            
            $append_query = "cmFarmid = \"" . $ids[0] . "\"";

            $append_query .= " AND cmDongid = \"" .(isset($ids[1]) ? $ids[1] : "01" ). "\"";      // 농장버튼 클릭시 해당 농장 1동을 가져와서 출력

            $select_query = "SELECT * FROM comein_master WHERE " . $append_query . " ORDER BY cmIndate DESC LIMIT 1";

            $select_data = get_select_data($select_query);

            $response["code"] = $select_data[0]["cmCode"];
            $response["cmIndate"] = $select_data[0]["cmIndate"];
            $response["cmOutdate"] = $select_data[0]["cmOutdate"];

            echo json_encode($response);
        }

        break;

	case "get_buffer":          //버퍼테이블

		$now = date("Y-m-d H:i:s");
		$to_day = date("Y-m-d");
		$yester_day = date("Y-m-d", strtotime("-1 Days"));
		$day_plus_1 = date("Y-m-d", strtotime("+1 Days"));
		$day_plus_2 = date("Y-m-d", strtotime("+2 Days"));

		$ref_date = date('Y-m-d H:i:s');
		$ref_date = substr($ref_date, 0, 15) . "0:00";

		$select_query = "SELECT cm.*, fd.fdName, fd.fdOutDays, be.*, sf.*, sc.*, sh.shFeedData, 
						IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as days, aw.awWeight 
						FROM comein_master AS cm
						LEFT JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid AND awDate = '" .$ref_date. "' 
						LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
						LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
						LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid
						LEFT JOIN set_camera AS sc ON sc.scFarmid = cm.cmFarmid AND sc.scDongid = cm.cmDongid 
						LEFT JOIN sensor_history AS sh ON sh.shFarmid = cm.cmFarmid AND sh.shDongid = cm.cmDongid AND shDate = \"" . substr($now, 0, 13) . ":00:00\" 
						WHERE cmCode = '" .$code. "'
						GROUP BY cm.cmCode, sc.scPort";

		$select_data = get_select_data($select_query);

		// 어제 및 오늘 평균중량 데이터
		$select_sql = "SELECT aw.* FROM 
							(SELECT awFarmid, awDongid, MAX(awDate) AS maxDate
							FROM avg_weight WHERE awFarmid = \"" .$farmID. "\" AND awDongid = \"" .$dongID. "\" AND 
							awDate BETWEEN \"" .$yester_day. " 00:00:00\" AND \"" .$to_day. " 23:59:00\"
							GROUP BY awFarmid, awDongid, LEFT(awDate, 10) ORDER BY maxDate DESC) AS maw
						JOIN avg_weight AS aw ON aw.awFarmid = maw.awFarmid AND aw.awDongid = maw.awDongid AND aw.awDate = maw.maxDate";

		$aw_data = get_select_data($select_sql);

		$curr_interm = $select_data[0]["days"];		 //현재 일령
		$curr_weight = $select_data[0]["beAvgWeight"];	 //현재 평균중량
		$curr_devi   = $select_data[0]["beDevi"];		 //현재 표준편차

		$daily_water = $select_data[0]["sfDailyWater"]; //일일 급수량
		$daily_feed  = $select_data[0]["sfDailyFeed"];  //일일 급이량

		$posi = count($aw_data) - 1;

		if($posi > -1){	 	// 어제 또는 오늘 데이터가 존재하는 경우
			$prev_weight = sprintf('%0.1f', $aw_data[$posi]["awWeight"]);	 //어제 평균중량
			$prev_esti1  = sprintf('%0.1f', $aw_data[$posi]["awEstiT1"]);	 //어제 +1 예측
			$prev_esti2  = sprintf('%0.1f', $aw_data[$posi]["awEstiT2"]);	 //어제 +2 예측
			$prev_esti3  = sprintf('%0.1f', $aw_data[$posi]["awEstiT3"]);	 //어제 +3 예측
			$prev_date   = sprintf('%0.1f', $aw_data[$posi]["awDate"]);	 //어제 마지막 산출 시간
		}
		else{	 // 없는 경우
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

		$row = $select_data[0];

		$summary_data = array();

		$summary_data["summary_name"] 	= $row["fdName"] . " (" . $row["cmFarmid"] . "-" . $row["cmDongid"] . ")";
		$summary_data["summary_days"] 	= $row["days"];
		$summary_data["summary_avg"] 	= number_format($row["beAvgWeight"], 0);
		$summary_data["summary_devi"] 	= number_format($row["beDevi"], 1);
		$summary_data["summary_inc"] 	= (empty($row["awWeight"]) ? "-" : number_format($row["beAvgWeight"] - $row["awWeight"], 0));
		$summary_data["summary_type"] 	= $row["cmIntype"] . " " . $row["cmInsu"] . "수";
		$summary_data["summary_comein"] = "입추일자 : " . substr($row["cmIndate"], 0, 10);
		$summary_data["summary_out_day"]= $row["fdOutDays"];
		
		$summary_data["summary_date_term1"]	=  substr($yester_day, 5);		/*어제 날짜*/
		$summary_data["summary_date_term2"]	=  substr($day_plus_1, 5);		/*내일 날짜*/
		$summary_data["summary_date_term3"]	=  substr($day_plus_2, 5);		/*모레 날짜*/

		$summary_data["summary_day_term1"]	= ($curr_interm - 1)."일령";	/*어제 일령*/
		$summary_data["summary_day_term2"]	= ($curr_interm + 1)."일령";	/*내일 일령*/
		$summary_data["summary_day_term3"]	= ($curr_interm + 2)."일령";	/*모레 일령*/

		$summary_data["summary_day_1"]	= $prev_weight;	/*어제 예측평체*/
		$summary_data["summary_day_2"]	= $prev_esti2;	/*내일 예측평체*/
		$summary_data["summary_day_3"]	= $prev_esti3;	/*모레 예측평체*/
				
		$summary_data["summary_avg_temp"] = sprintf('%0.1f', $row["beAvgTemp"] + corr_temp);	/*현재 온도 센서 평균*/
		$summary_data["summary_avg_humi"] = sprintf('%0.1f', $row["beAvgHumi"] + corr_humi);	/*현재 습도 센서 평균*/
		$summary_data["summary_avg_co2"]  = sprintf('%0.1f', $row["beAvgCo2"] + corr_co2);		/*현재 이산화탄소 센서 평균*/
		$summary_data["summary_avg_nh3"]  = sprintf('%0.1f', $row["beAvgNh3"] + corr_nh3);		/*현재 암모니아 센서 평균*/

		//카메라
		$img_url = "../common/php_module/camera_func.php?ip=" .$row["beIPaddr"]. "&port=" .$row["scPort"]. "&url=" .urlencode($row["scUrl"]). "&id=" .$row["scId"]. "&pw=" .$row["scPw"];
		$summary_data["summary_camera"] = "<img src='" .$img_url. "' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg'); $('#cameraIcon').hide();\">
										<img id='cameraIcon' src='../images/play.png' class='fadeIn animated' onClick=\"camera_popup('" .$name. "','" .$img_url. "'); \">";

		// $summary_data["summary_indate"] = $row["cmIndate"];
		// $summary_data["summary_outdate"] = $row["cmOutdate"];

		$response["summary_data"] = $summary_data;

		// 일일 / 전일 급이 급수
		$extra = array();
		if($row["sfFarmid"] != ""){		// 급이 데이터가 있으면
			$extra["extra_curr_feed"]   = $row["sfDailyFeed"];
			$extra["extra_prev_feed"]   = $row["sfPrevFeed"];
			$extra["extra_curr_water"]  = $row["sfDailyWater"];
			$extra["extra_prev_water"]  = $row["sfPrevWater"];
			$extra["extra_feed_remain"] = $row["sfFeed"];

			$feed_json = json_decode($row["shFeedData"]);
			$extra["extra_water_per_hour"] = $feed_json->feed_water;

			// 남은 사료빈 용량 확인
			$feed_max = $row["sfFeedMax"];
			$curr_feed = $row["sfFeed"];

			$percent = $curr_feed / $feed_max;

			$percent = round($percent * 100);

			$extra["extra_feed_percent"] = $percent . "%";
		}
		else{
			$extra["extra_curr_feed"] 	   = "-";
			$extra["extra_prev_feed"] 	   = "-";
			$extra["extra_curr_water"]	   = "-";
			$extra["extra_prev_water"]	   = "-";
			$extra["extra_feed_remain"]    = "-";
			$extra["extra_water_per_hour"] = "-";
			$extra["extra_feed_percent"]   = "-%";
		}

		$response["extra"] = $extra;

		echo json_encode($response);
	
		break;

	case "get_sensor_history":
		$result = get_cell_history($code, "get_all");

		$response["chart_temp"] = $result["chart_temp"];
		$response["chart_humi"] = $result["chart_humi"];
		$response["chart_co2"]  = $result["chart_co2"];
		$response["chart_nh3"]  = $result["chart_nh3"];
		$response["table"] = $result["table"];

		echo json_encode($response);
		break;
		
	case "get_avg_weight":

		$avg_history = get_avg_history($code, $_REQUEST["term"], "all");

		switch($_REQUEST["comm"]){
			case "view":
				$response["avg_weight_chart"] = $avg_history["chart"];
                $response["avg_weight_table"] = $avg_history["table"];

				echo json_encode($response);
				break;
			
			case "excel":
				$excel_title = date('Ymd_His') . "_" . $avg_history["name"] . "_평균중량.xls";
				
				$field_data = array(
					/*농가 정보*/
					array("번호", "No", "INT", "center"),
					array("농장ID", "awFarmid", "STR", "center"),
					array("동ID", "awDongid", "STR", "center"),
					array("농장명", "fdName", "STR", "center"),
					array("일령", "awDays", "STR", "center"),
					array("산출시간", "awDate", "STR", "center"),
					array("예측중량", "awWeight", "STR", "center"),
					array("권고중량", "refWeight", "STR", "center"),
					array("표준편차", "awDevi", "STR", "center"),
					array("변이계수", "awVc", "STR", "center"),
					array("+1 예측", "awEstiT1", "STR", "center"),
					array("+2 예측", "awEstiT2", "STR", "center"),
					array("+3 예측", "awEstiT3", "STR", "center"),
					//array("정규분포", "awNdis", "STR", "left"),
				);

				// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				$excel_html = convert_excel(get_select_data($avg_history["query"]), $field_data, $excel_title, $code, false);
				
				$response["excel_title"] = $excel_title; 
				$response["excel_html"]  = $excel_html;
				
				echo json_encode($response);

				break;
		}
		break;
		
	case "get_request_history":          //재산출 이력

		$select_query = "SELECT * FROM request_calculate WHERE rcFarmid = \"" . $farmID . "\" AND rcDongid = \"" . $dongID . "\" 
						AND (rcRequestDate BETWEEN \"" . $_REQUEST["indate"] . "\" AND \"" . date('Y-m-d H:i:s') . "\") ORDER BY rcRequestDate DESC";

		$select_data = get_select_data($select_query);

		$request_history_data = array();
		foreach($select_data as $row){

			$change_status = "";
			$change_str = "";

			$checker = explode("|", $row["rcCommand"]);

			if(in_array("Day", $checker)){
				$change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevDate"] . " -> " . $row["rcChangeDate"];
				$change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Day(일령)";
			}

			if(in_array("Lst", $checker)){
				$change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevLst"] . " -> " . $row["rcChangeLst"];
				$change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Lst(축종)";
			}

			if(in_array("Opt", $checker)){
				$change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevRatio"] . " -> " . $row["rcChangeRatio"];
				$change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Opt(재산출)";
			}

			$request_history_data[] = array(
				'f1'  => $row["rcRequestDate"],							
				'f2'  => $change_status,									
				'f3'  => $change_str,
				'f4'  => $row["rcMeasureDate"],
				'f5'  => $row["rcMeasureVal"],	
				'f6'  => $row["rcPrevWeight"],									
			);
		}

		$response["request_history_data"] = $request_history_data;

		echo json_encode($response);
		break;
		
	case "get_all":
		$result = get_feed_history($code, $oper);
		$response["chart_feed"] = $result["chart_feed_daily"];
		$response["chart_water"] = $result["chart_water_daily"];

		echo json_encode($response);
		break;

	// case "get_":
	// 	break;
	
};
	
?>