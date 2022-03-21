<?

include_once("../common/php_module/common_func.php");
	
	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$cmCode = $_REQUEST["cmCode"];
		$id = explode("_", $cmCode)[1];
		$farmID = substr($id, 0, 6);
		$dongID = substr($id, 6);
	};

	switch($oper){
		case "get_avg_weight":

			$avg_history = get_avg_history($cmCode, $_REQUEST["term"], "all");

			switch($_REQUEST["comm"]){
				case "view":
					$response["avg_weight_table"] = $avg_history["table"];
					$response["avg_weight_chart"] = $avg_history["chart"];
					
					echo json_encode($response);

					break;
				
				case "excel":
					$title = $farmID . "_" . $dongID . "_평균중량";
	
					header("Content-Type: application/vnd.ms-excel");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("content-disposition: attachment; filename=" . date('Ymd_His') . "_" . $title . ".xls");
	
					$field_data = array(
						/*농가 정보*/
						array("번호",       "No", "INT", "center"),
						array("농장ID",     "awFarmid", "STR", "center"),
						array("동ID",       "awDongid", "STR", "center"),
						array("산출시간",   "awDate", "STR", "center"),
						array("예측중량",   "awWeight", "STR", "center"),
						array("권고중량",   "refWeight", "STR", "center"),
						array("표준편차",   "awDevi", "STR", "center"),
						array("변이계수",   "awVc", "STR", "center"),
						array("+1 예측",    "awEstiT1", "STR", "center"),
						array("+2 예측",    "awEstiT2", "STR", "center"),
						array("+3 예측",    "awEstiT3", "STR", "center"),
						array("일령",       "awDays", "STR", "center"),
						array("정규분포",   "awNdis", "STR", "left"),
					);
	
					convert_excel(get_select_data($select_query), $field_data, $title, $cmCode);
					break;
			};

			break;

		case "get_cell_status":
			$select_query = "SELECT cm.cmFarmid, cm.cmDongid, si.* FROM comein_master AS cm
							 LEFT JOIN set_iot_cell AS si ON si.siFarmid = cm.cmFarmid AND si.siDongid = cm.cmDongid WHERE cmCode = '" . $cmCode . "'";		

			$select_data = get_select_data($select_query);

			foreach($select_data as $val){
				$cell_data[] = array(
					'f1' => "IoT저울-". $val["siCellid"],
					'f2' => sprintf('%0.1f', $val["siWeight"]),
					'f3' => sprintf('%0.1f', $val["siTemp"]),
					'f4' => sprintf('%0.1f', $val["siHumi"]),
					'f5' => sprintf('%0.1f', $val["siCo2"]),
					'f6' => sprintf('%0.1f', $val["siNh3"]),
				);
			};
			$response["cell_data"] = $cell_data;

			echo json_encode($response);

			break;

		case "get_ndis_chart":

			// $select_query = "SELECT awNdis FROM avg_weight WHERE awFarmid = '". $farmID ."' AND awDongid = '". $dongID ."' ORDER BY awDate DESC LIMIT 1";
			$select_query = "SELECT cm.cmInsu, aw.awNdis FROM comein_master AS cm
						LEFT JOIN avg_weight AS aw ON aw.awFarmid = cm.cmFarmid AND aw.awDongid = cm.cmDongid
						AND (aw.awDate BETWEEN cm.cmIndate AND 
							(CASE WHEN (cm.cmOutdate is null) THEN NOW() 
								WHEN (cm.cmOutdate = '2000-01-01 00:00:00') THEN NOW() 
							ELSE cm.cmOutdate END))
						WHERE cmCode = '".$cmCode."' ORDER BY aw.awDate DESC LIMIT 1";

			$select_data = get_select_data($select_query);

			$response["ndis_data"] = $select_data;

			echo json_encode($response);

			break;

		case "get_inc_weight":

			$result = get_avg_history($cmCode, "time", "day");

			$response["today_inc_weight"] = $result["increase"];
			
			echo json_encode($response);

			break;

		case "get_sensor_history":
			$result = get_cell_history($cmCode, "get_all");

			$response["chart_temp"] = $result["chart_temp"];
			$response["chart_humi"] = $result["chart_humi"];
			$response["chart_co2"] =  $result["chart_co2"];
			$response["chart_nh3"] =  $result["chart_nh3"];
			$response["table"] = 	$result["table"];

			echo json_encode($response);
			break;
	}
?>