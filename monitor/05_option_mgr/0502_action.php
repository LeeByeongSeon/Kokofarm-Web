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
			
			$append_query = "AND suAddr = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND suAddr = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM set_plc_unitid WHERE suAddr = suAddr " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		$unitID = check_str($_REQUEST["suAddr"]);

		$insert_map = array();

        $insert_map["suAddr"]      = $unitID;
        $insert_map["suProperty"]  = check_str($_REQUEST["suProperty"]);
        $insert_map["suName"]      = check_str($_REQUEST["suName"]);
        $insert_map["suRemark"]    = check_str($_REQUEST["suRemark"]);
        $insert_map["suParseRule"] = check_str($_REQUEST["suParseRule"]);

		run_sql_insert("set_plc_unitid", $insert_map);

		break;


	case "edit":
		$unitID = check_str($_REQUEST["suAddr"]);

		$update_map = array();

        $update_map["suProperty"]  = check_str($_REQUEST["suProperty"]);
        $update_map["suName"]      = check_str($_REQUEST["suName"]);
        $update_map["suRemark"]    = check_str($_REQUEST["suRemark"]);
        $update_map["suParseRule"] = check_str($_REQUEST["suParseRule"]);

		$where_query = "suAddr = \"" .$unitID. "\"";

		run_sql_update("set_plc_unitid", $update_map, $where_query);

		break;

	case "del":
		$unitID = check_str($_REQUEST["id"]);

		$where_query = "suAddr = " .$unitID;

        // Delete
		run_sql_delete("set_plc_unitid", $where_query);

		break;


	case "excel":
		$title = "PLC Unit ID 관리";

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
			
			$append_query = "AND suAddr = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND suAddr = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM set_plc_unitid WHERE suAddr = suAddr " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("PLC주소", "suAddr", "STR", "center"),
			array("PLC속성", "suProperty", "STR", "center"),
			array("장치명(유닛명)", "suName", "STR", "center"),
			array("장치설명", "suRemark", "STR", "center"),
			array("파싱규칙", "suParseRule", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>