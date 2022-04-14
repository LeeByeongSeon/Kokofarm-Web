<?

include_once("../common/php_module/common_func.php");

$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

if(isset($_REQUEST["cmCode"])){
	$code = $_REQUEST["cmCode"];
	$id = explode("_", $code)[1];
	$farmID = substr($id, 0, 6);
	$dongID = substr($id, 6);
};

$response = array();

switch($oper){

	case "get_info":

		$select_query = "SELECT * FROM comein_master WHERE cmCode = \"" .$code. "\"";
					  
		$comein_data = get_select_data($select_query);
		
		$response["comein_data"] = $comein_data[0];

		echo json_encode($response);

		break;

	case "get_breed_data":

		$breed_table = array();

		$select_query = "SELECT cm.*, cd.*, IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) AS inTerm 
						FROM comein_master AS cm LEFT JOIN comein_detail AS cd ON cd.cdCode = cm.cmCode WHERE cm.cmCode = \"" .$code. "\" ";
						
		$breed_data = get_select_data($select_query);

		$start_date = substr($breed_data[0]["cmIndate"], 0, 10);
		$now_date = $breed_data[0]["cmOutdate"] == "" ? date("Y-m-d") : substr($breed_data[0]["cmOutdate"], 0, 10);

		$date_list = array();

		foreach($breed_data as $row){
			$date_list[$row["cdDate"]] = $row;
		}

		$day = 1;
		$live = $row["cmInsu"];

		while(true){
			if(array_key_exists($start_date, $date_list)){

				$live = $live - $row["cdDeath"] - $row["cdCull"] - $row["cdThinout"];
				$row = $date_list[$start_date];
				$breed_table[] = array(
					'f_interm' 		=> $day++,
					'f_date' 		=> $start_date,
					'f_live' 		=> $live,
					'f_death' 		=> $row["cdDeath"],
					'f_cull' 		=> $row["cdCull"],
					'f_thinout' 	=> $row["cdThinout"]
				);
			}
			else{
				$breed_table[] = array(
					'f_interm' 		=> $day++,
					'f_date' 		=> $start_date,
					'f_live' 		=> $live,
					'f_death' 		=> 0,
					'f_cull' 		=> 0,
					'f_thinout' 	=> 0
				);
			}

			if($start_date == $now_date){
				break;
			}

			$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
		}

		$response["comein_data"] = $breed_data[0];
		$response["breed_table"] = $breed_table;

		echo json_encode($response);

		break;

	case "save_breed_data":

		$insert_map = array();

		$insert_map["cdCode"] 	    	= $code; 								//입출하 코드
		$insert_map["cdDate"] 	    	= $_REQUEST["date"]; 					//입력 기준시간

		$insert_map["cdDeath"] 	 		= check_str($_REQUEST["death_count"]); 			//폐사 수
		$insert_map["cdCull"]   		= check_str($_REQUEST["cull_count"]); 			//도태 수
		$insert_map["cdThinout"]    	= check_str($_REQUEST["thinout_count"]); 		//솎기 수
		$insert_map["cdInputDate"]  	= date("Y-m-d H:i:s");

		run_sql_upsert("comein_detail", $insert_map, array("cdCode", "cdDate"));

		// 입추수 변경
		$update_query = "UPDATE comein_master AS cm 
							JOIN (
								SELECT cm.*, SUM(cd.cdDeath) AS cdDeath, SUM(cd.cdCull) AS cdCull, SUM(cd.cdThinout) AS cdThinout FROM comein_master AS cm 
								LEFT JOIN comein_detail AS cd ON cd.cdCode = cm.cmCode
								WHERE cmCode = \"".$code."\" GROUP BY cm.cmCode
							) AS t ON cm.cmCode = t.cmCode SET ";
		$update_query .= " cm.cmInsu = " . check_str($_REQUEST["comein_count"]);
		$update_query .= ", cm.cmDeathCount = t.cdDeath";
		$update_query .= ", cm.cmCullCount = t.cdCull";
		$update_query .= ", cm.cmThinoutCount = t.cdThinout";
		$update_query .= " WHERE cm.cmCode = \"".$code."\"";
		run_query($update_query);

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

			if(strpos($comm, "Opt") !== false){		//실측이 있는 경우에만 입력
				$insert_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);	//실측 시간
				$insert_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]); 	//실측 중량
			}

			run_sql_insert("request_calculate", $insert_map);
		}

		// 입추수 변경
		$update_map = array();
		$update_map["cmInsu"] = check_str($_REQUEST["change_insu"]);
		$where_query = "cmCode = \"".$code."\"";
		run_sql_update("comein_master", $update_map, $where_query);

		$response["ok"] = true;

		echo json_encode($response);

		break;
}
?>