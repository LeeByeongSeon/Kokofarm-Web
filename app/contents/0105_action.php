<?

include_once("../../common/php_module/common_func.php");

$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

if(isset($_REQUEST["cmCode"])){
	$cmCode = $_REQUEST["cmCode"];
	$id = explode("_", $cmCode)[1];
	$farmID = substr($id, 0, 6);
	$dongID = substr($id, 6);
};

$response   = array();

switch($oper){

	case "get_intype":
		
		$day = check_str($_REQUEST["day"]);	//일령

		$get_query = "SELECT cm.cmIntype, cm.cmInsu, cm.cmIndate, rc.rcStatus, rc.rcRequestDate FROM comein_master AS cm
					  JOIN request_calculate AS rc ON rc.rcFarmid = cm.cmFarmid AND rc.rcDongid = cm.cmDongid
					  WHERE cmCode = \"$cmCode\" ORDER BY rcRequestDate DESC LIMIT 1";
					  
		$get_data = get_select_data($get_query);

		//var_dump($get_query);
		
		$response["cm_in_type"] = $get_data[0]["cmIntype"];
		$response["cm_in_date"] = $get_data[0]["cmIndate"];
		$response["cm_in_su"]   = $get_data[0]["cmInsu"];
		$response["status"] 	= "";
		$response["msg"] 		= "";
		$response["view_alert"] = false;

		$rc_request_date = "";

		if(count($get_data) > 0){
			$rc_status = $get_data[0]["rcStatus"];
			$rc_request_date = $get_data[0]["rcRequestDate"];

			$response["status"] = $rc_status;

			// 상태별 메시지
			switch($rc_status){
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
			if(substr($rc_request_date, 0, 10) != date("Y-m-d")){			// 해당일자에 요청한 데이터가 없는지 확인 
				$response["view_alert"] = true;
			}
		}

		echo json_encode($response);

		break;

	case "edit_intype":

		$insert_map = array();

		$insert_map["rcFarmid"] 	    = $farmID; 								//농장 ID
		$insert_map["rcDongid"] 	    = $dongID; 								//동 ID
		$insert_map["rcRequestDate"] 	= date("Y-m-d H:i:s"); 					//요청 시간
		$insert_map["rcCode"] 	    	= $cmCode;								//입추코드
		$insert_map["rcCommand"]		= check_str($_REQUEST["rcCommand"]); 	//산출 명령
		$insert_map["rcStatus"] 	    = "R";									//작업 상태 (초기는 R (Request))

		$insert_map["rcPrevLst"] 	 = check_str($_REQUEST["rcPrevLst"]); 		//변경 전 축종
		$insert_map["rcChangeLst"]   = check_str($_REQUEST["rcChangeLst"]); 	//변경 후 축종
		$insert_map["rcPrevDate"]    = check_str($_REQUEST["rcPrevDate"]); 		//변경 전 입추시간
		$insert_map["rcChangeDate"]  = check_str($_REQUEST["rcChangeDate"]); 	//변경 후 입추시간
		$insert_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);	//실측 시간
		$insert_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]); 	//실측 중량

		run_sql_insert("request_calculate", $insert_map);


		$update_map = array();

		$update_map["cmInsu"] = check_str($_REQUEST["tr_count"]);
		
		$where_query = "cmCode = \"".$cmCode."\"";

		run_sql_update("comein_master", $update_map, $where_query);

		$response["change_inSU"] = $update_map["cmInsu"];

		echo json_encode($response);

		break;
}
?>