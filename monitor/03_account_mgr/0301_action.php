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

		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND scFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND scDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT DISTINCT f.*, beIPaddr,
                            (SELECT COUNT(*) FROM set_iot_cell WHERE siFarmid = fFarmid) AS cnt_si,
                            (SELECT COUNT(*) FROM set_camera WHERE scFarmid = fFarmid) AS cnt_sc,
                            (SELECT COUNT(*) FROM set_plc WHERE spFarmid = fFarmid) AS cnt_sp,
                            (SELECT COUNT(*) FROM set_feeder WHERE sfFarmid = fFarmid) AS cnt_sf,
                            (SELECT COUNT(*) FROM set_outsensor WHERE soFarmid = fFarmid) AS cnt_so
						FROM farm AS f
                        JOIN buffer_sensor_status AS be ON be.beFarmid = f.fFarmid ". $append_query;
        
		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["fID"]);

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\"";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["fID"] 		  = $farmID;
			$insert_map["fPW"] 		  = check_str($_REQUEST["fPW"]);
			$insert_map["fGroupName"] = check_str($_REQUEST["fGroupName"]);
			$insert_map["fGroupid"]   = check_str($_REQUEST["fGroupid"]);
			$insert_map["fFarmid"] 	  = check_str($_REQUEST["fFarmid"]);
			$insert_map["fCeo"] 	  = check_str($_REQUEST["fCeo"]);
			$insert_map["fName"] 	  = check_str($_REQUEST["fName"]);

			run_sql_insert("set_camera", $insert_map);
		}
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

		$where_query = "fID = \"" .$pk. "\" ";

		//농장 계정 삭제
		run_sql_delete("farm", $where_query);

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
		$append_sql = "";

		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND scFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND scDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT f.*, beIPaddr,
							(SELECT COUNT(*) FROM set_iot_cell WHERE siFarmid = fFarmid) AS cnt_si,
							(SELECT COUNT(*) FROM set_camera WHERE scFarmid = fFarmid) AS cnt_sc,
							(SELECT COUNT(*) FROM set_plc WHERE spFarmid = fFarmid) AS cnt_sp,
							(SELECT COUNT(*) FROM set_feeder WHERE sfFarmid = fFarmid) AS cnt_sf,
							(SELECT COUNT(*) FROM set_outsensor WHERE soFarmid = fFarmid) AS cnt_so
						FROM farm AS f
						JOIN buffer_sensor_status AS be ON be.beFarmid = f.fFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

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
			array("IP", "beIPaddr", "STR", "center"),
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