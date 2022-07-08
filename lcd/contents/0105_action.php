<?

include_once("../common/php_module/common_func.php");

$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

if(isset($_REQUEST["cmCode"])){
	$code = $_REQUEST["cmCode"];
	$id = explode("_", $code)[1];
	$farmID = substr($id, 0, 6);
	$dongID = substr($id, 6);
};

$response   = array();

switch($oper){

	case "get_info":

		$select_query = "SELECT * FROM comein_master WHERE cmCode = \"" .$code. "\"";
					  
		$comein_data = get_select_data($select_query);
		
		$response["comein_data"] = $comein_data[0];

		echo json_encode($response);

		break;

	case "request":

		$comm = check_str($_REQUEST["rcCommand"]);

		if($comm != ""){		// 입추수 외에 변경사항 존재 시
			$insert_map = array();

			$insert_map["rcFarmid"] 	    = $farmID; 								//농장 ID
			$insert_map["rcDongid"] 	    = $dongID; 								//동 ID
			$insert_map["rcRequestDate"] 	= date("Y-m-d H:i:s"); 					//요청 시간
			$insert_map["rcCode"] 	    	= $code;								//입추코드
			$insert_map["rcCommand"]		= $comm; 								//산출 명령
			$insert_map["rcStatus"] 	    = "R";									//작업 상태 (초기는 R (Request))

			$insert_map["rcPrevLst"] 	 = check_str($_REQUEST["rcPrevLst"]); 		//변경 전 축종
			$insert_map["rcChangeLst"]   = check_str($_REQUEST["rcChangeLst"]); 	//변경 후 축종
			$insert_map["rcPrevDate"]    = check_str($_REQUEST["rcPrevDate"]); 		//변경 전 입추시간
			$insert_map["rcChangeDate"]  = check_str($_REQUEST["rcChangeDate"]); 	//변경 후 입추시간

			// if(strpos($comm, "Opt") !== false){		//실측이 있는 경우에만 입력
			// 	$insert_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);	//실측 시간
			// 	$insert_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]); 	//실측 중량
			// }

			run_sql_insert("request_calculate", $insert_map);
		}

		// // 입추수 변경
		// $update_map = array();
		// $update_map["cmInsu"] = check_str($_REQUEST["change_insu"]);
		// $where_query = "cmCode = \"".$code."\"";
		// run_sql_update("comein_master", $update_map, $where_query);

		$response["ok"] = true;

		echo json_encode($response);

		break;
}
?>