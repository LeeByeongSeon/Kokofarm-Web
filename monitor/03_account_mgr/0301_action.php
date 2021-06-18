<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	default:
		$page  = check_str($_REQUEST['page']); // jqGrid의 page 속성의 값
		$limit = check_str($_REQUEST['rows']); // jqGrid의 rowNum 속성의 값
		$sidx  = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
		$sord  = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

		//검색필드
		$append_query = "";

		if(isset($_REQUEST["search_data"])){
			$search_data = $_REQUEST["search_data"];
			$search_json = json_decode(stripslashes($search_data), true);

			$append_query = ($search_json["search_name"] == "") ? $append_query : $append_query . " AND (fName LIKE \"%" .$search_json["search_name"]. "%\" OR fID LIKE \"%" .$search_json["search_name"]. "%\") ";
			$append_query = ($search_json["search_group"] == "") ? $append_query : $append_query . " AND fGroupName = \"" .$search_json["search_group"]. "\" ";
		}

		//jqgrid 출력
		$select_query = "SELECT *, 
                            (SELECT COUNT(*) FROM set_iot_cell WHERE siFarmid = fFarmid) AS cnt_si,
                            (SELECT COUNT(*) FROM set_camera WHERE scFarmid = fFarmid) AS cnt_sc,
                            (SELECT COUNT(*) FROM set_plc WHERE spFarmid = fFarmid) AS cnt_sp,
                            (SELECT COUNT(*) FROM set_feeder WHERE sfFarmid = fFarmid) AS cnt_sf,
                            (SELECT COUNT(*) FROM set_outsensor WHERE soFarmid = fFarmid) AS cnt_so
						FROM farm WHERE fID = fID ". $append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$pk = check_str($_REQUEST["fID"]);

		$insert_map = array();

		$insert_map["fID"] 		  = $pk;
		$insert_map["fPW"] 		  = check_str($_REQUEST["fPW"]);
		$insert_map["fGroupName"] = check_str($_REQUEST["fGroupName"]);
		$insert_map["fGroupid"]   = check_str($_REQUEST["fGroupid"]);
		$insert_map["fFarmid"] 	  = check_str($_REQUEST["fFarmid"]);
		$insert_map["fCeo"] 	  = check_str($_REQUEST["fCeo"]);
		$insert_map["fName"] 	  = check_str($_REQUEST["fName"]);

		run_sql_insert("farm", $insert_map);

		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);

		$update_map = array();

		$update_map["fPW"] 		  = check_str($_REQUEST["fPW"]);
		$update_map["fGroupName"] = check_str($_REQUEST["fGroupName"]);
		$update_map["fGroupid"]   = check_str($_REQUEST["fGroupid"]);
		$update_map["fFarmid"] 	  = check_str($_REQUEST["fFarmid"]);
		$update_map["fCeo"] 	  = check_str($_REQUEST["fCeo"]);
		$update_map["fName"] 	  = check_str($_REQUEST["fName"]);

		$where_query = "fID = \"" .$pk. "\" ";

		run_sql_update("farm", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);

		//하위 데이터 삭제를 위해 fFarmid를 가져온 후 농장 계정 삭제
		$where_query = "fID = \"" .$pk. "\" ";
		$farmID = get_select_data("SELECT fFarmid FROM farm WHERE " . $where_query)[0]["fFarmid"];

		run_sql_delete("farm", $where_query);

		$where_query = "Farmid = \"" .$farmID. "\" ";

		//동 계정 삭제
		run_sql_delete("farm_detail", "fd" . $where_query);

		//버퍼테이블 삭제
		run_sql_delete("buffer_sensor_status", 		"be" . $where_query);
		run_sql_delete("buffer_plc_status", 		"bp" . $where_query);

		//장치 계정 삭제
		run_sql_delete("set_iot_cell", 				"si" . $where_query);
		run_sql_delete("set_camera", 				"sc" . $where_query);
		run_sql_delete("set_plc", 					"sp" . $where_query);
		run_sql_delete("set_feeder", 				"sf" . $where_query);
		run_sql_delete("set_outsensor", 			"so" . $where_query);

		break;


	case "excel":
		$title = "농장 계정 관리";

		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=" . date('Ymd_His') . "_" . $title . ".xls");

		$sidx = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
		$sord = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

		//검색필드
		$append_query = "";

		if(isset($_REQUEST["search_data"])){
			$search_data = check_str($_REQUEST["search_data"]);
			$search_json = json_decode(stripslashes($search_data), true);

			$append_query = ($search_json["search_name"] == "") ? $append_query : $append_query . " AND (fName LIKE \"%" .$search_json["search_name"]. "%\" OR fID LIKE \"%" .$search_json["search_name"]. "%\") ";
			$append_query = ($search_json["search_group"] == "") ? $append_query : $append_query . " AND fGroupName = \"%" .$search_json["search_group"]. "%\" ";
		}

		//jqgrid 출력
		$select_query = "SELECT *, 
							(SELECT COUNT(*) FROM set_iot_cell WHERE siFarmid = fFarmid) AS cnt_si,
							(SELECT COUNT(*) FROM set_camera WHERE scFarmid = fFarmid) AS cnt_sc,
							(SELECT COUNT(*) FROM set_plc WHERE spFarmid = fFarmid) AS cnt_sp,
							(SELECT COUNT(*) FROM set_feeder WHERE sfFarmid = fFarmid) AS cnt_sf,
							(SELECT COUNT(*) FROM set_outsensor WHERE soFarmid = fFarmid) AS cnt_so
						FROM farm " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장주ID", "fID", "STR", "center"),
			array("농장주pw", "fPW", "STR", "center"),
			array("계열회사", "fGroupName", "STR", "center"),
			array("계열화회사ID", "fGroupid", "STR", "center"),
			array("농장ID", "fFarmid", "STR", "center"),
			array("농장주명", "fCeo", "STR", "center"),
			array("농장명", "fName", "STR", "center"),
			array("IoT 저울", "cnt_si", "STR", "center"),
			array("IP 카메라", "cnt_sc", "STR", "center"),
			array("PLC", "cnt_sp", "STR", "center"),
			array("급이", "cnt_sf", "STR", "center"),
			array("급수", "cnt_sf", "STR", "center"),
			array("외기", "cnt_so", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>