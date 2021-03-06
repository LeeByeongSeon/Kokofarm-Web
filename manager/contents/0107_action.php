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
						FROM comein_master AS cm LEFT JOIN comein_detail AS cd ON cd.cdCode = cm.cmCode WHERE cm.cmCode = \"" .$code. "\" ORDER BY cdDate";
						
		$breed_data = get_select_data($select_query);

		$start_date = substr($breed_data[0]["cmIndate"], 0, 10);
		$now_date = $breed_data[0]["cmOutdate"] == "" ? date("Y-m-d") : substr($breed_data[0]["cmOutdate"], 0, 10);

		$date_list = array();

		foreach($breed_data as $row){
			$date_list[$row["cdDate"]] = $row;
		}

		$day = 1;
		$live = $breed_data[0]["cmInsu"];

		while(true){

			if(array_key_exists($start_date, $date_list)){

				$row = $date_list[$start_date];
				$live = $live - $row["cdDeath"] - $row["cdCull"] - $row["cdThinout"];

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

		$insert_map["cdCode"] 	    	= $code; 								//????????? ??????
		$insert_map["cdDate"] 	    	= $_REQUEST["date"]; 					//?????? ????????????

		$insert_map["cdDeath"] 	 		= check_str($_REQUEST["death_count"]); 			//?????? ???
		$insert_map["cdCull"]   		= check_str($_REQUEST["cull_count"]); 			//?????? ???
		$insert_map["cdThinout"]    	= check_str($_REQUEST["thinout_count"]); 		//?????? ???
		$insert_map["cdInputDate"]  	= date("Y-m-d H:i:s");

		run_sql_upsert("comein_detail", $insert_map, array("cdCode", "cdDate"));

		// ????????? ??????
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

		if($comm != ""){		// ????????? ?????? ???????????? ?????? ???
			$insert_map = array();

			$insert_map["rcFarmid"] 	    = $farmID; 								//?????? ID
			$insert_map["rcDongid"] 	    = $dongID; 								//??? ID
			$insert_map["rcRequestDate"] 	= date("Y-m-d H:i:s"); 					//?????? ??????
			$insert_map["rcCode"] 	    	= $code;								//????????????
			$insert_map["rcCommand"]		= $comm; 								//?????? ??????
			$insert_map["rcStatus"] 	    = "R";									//?????? ?????? (????????? R (Request))

			$insert_map["rcPrevLst"] 	 = check_str($_REQUEST["rcPrevLst"]); 		//?????? ??? ??????
			$insert_map["rcChangeLst"]   = check_str($_REQUEST["rcChangeLst"]); 	//?????? ??? ??????
			$insert_map["rcPrevDate"]    = check_str($_REQUEST["rcPrevDate"]); 		//?????? ??? ????????????
			$insert_map["rcChangeDate"]  = check_str($_REQUEST["rcChangeDate"]); 	//?????? ??? ????????????

			if(strpos($comm, "Opt") !== false){		//????????? ?????? ???????????? ??????
				$insert_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);	//?????? ??????
				$insert_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]); 	//?????? ??????
			}

			run_sql_insert("request_calculate", $insert_map);
		}

		// ????????? ??????
		$update_map = array();
		$update_map["cmInsu"] = check_str($_REQUEST["change_insu"]);
		$where_query = "cmCode = \"".$code."\"";
		run_sql_update("comein_master", $update_map, $where_query);

		$response["ok"] = true;

		echo json_encode($response);

		break;
}
?>