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
			
			$append_query = "AND fdFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND fdDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(fdFarmid, '|', fdDongid) AS pk FROM farm_detail WHERE fdFarmid = fdFarmid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["fdFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["fdDongid"]));

		$check_query = "SELECT fFarmid FROM farm WHERE fFarmid = \"" .$farmID. "\"";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["fdFarmid"] = $farmID;
			$insert_map["fdDongid"] = $dongID;
			$insert_map["fdName"] 	= check_str($_REQUEST["fdName"]);
			$insert_map["fdTel"] 	= check_str($_REQUEST["fdTel"]);
			$insert_map["fdType"] 	= check_str($_REQUEST["fdType"]);
			$insert_map["fdScale"] 	= check_str($_REQUEST["fdScale"]);
			$insert_map["fdAddr"] 	= check_str($_REQUEST["fdAddr"]);

			run_sql_insert("farm_detail", $insert_map);

			$insert_map = array();
			$insert_map["beFarmid"] = $farmID;
			$insert_map["beDongid"] = $dongID;

			run_sql_insert("buffer_sensor_status", $insert_map);
			
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$update_map = array();

		$update_map["fdName"]  = check_str($_REQUEST["fdName"]);
		$update_map["fdTel"]   = check_str($_REQUEST["fdTel"]);
		$update_map["fdType"]  = check_str($_REQUEST["fdType"]);
		$update_map["fdScale"] = check_str($_REQUEST["fdScale"]);
		$update_map["fdAddr"]  = check_str($_REQUEST["fdAddr"]);

		$where_query = "fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\"";

		run_sql_update("farm_detail", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$temp_1 = "Farmid = \"" .$farmID. "\" AND ";
		$temp_2 = "Dongid = \"" .$dongID. "\"";

		//$where_query = "fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\"";
		// 동 계정 삭제
		run_sql_delete("farm_detail", 			"fd" . $temp_1 . "fd" . $temp_2);

		//버퍼 테이블 삭제
		run_sql_delete("buffer_sensor_status", 	"be" . $temp_1 . "be" . $temp_2);
		run_sql_delete("buffer_plc_status", 	"bp" . $temp_1 . "bp" . $temp_2);

		// 장치 계정 삭제
		run_sql_delete("set_iot_cell", 		"si" . $temp_1 . "si" . $temp_2);
		run_sql_delete("set_camera", 		"sc" . $temp_1 . "sc" . $temp_2);
		run_sql_delete("set_plc", 			"sp" . $temp_1 . "sp" . $temp_2);
		run_sql_delete("set_feeder", 		"sf" . $temp_1 . "sf" . $temp_2);
		run_sql_delete("set_outsensor", 	"so" . $temp_1 . "so" . $temp_2);

		break;


	case "excel":
		$title = "농장별 동 관리";

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
			
			$append_query = "AND fdFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND fdDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(fdFarmid, '|', fdDongid) AS pk FROM farm_detail WHERE fdFarmid = fdFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "fdFarmid", "STR", "center"),
			array("동ID", "fdDongid", "STR", "center"),
			array("계열회사", "fGroupName", "STR", "center"),
			array("동이름", "fdName", "STR", "center"),
			array("전화번호", "fdTel", "STR", "center"),
			array("생계구분", "fdType", "STR", "center"),
			array("사육규모", "fdScale", "STR", "center"),
			array("주소", "fdAddr", "STR", "center"),
		);

		convert_excel(get_select_data($select_query), $field_data, $title, $append_query);
		break;
}

?>