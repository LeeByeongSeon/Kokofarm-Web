<?

include_once("../../common/php_module/common_func.php");

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
			
			$append_query = "AND cCode = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND cCode = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM codeinfo WHERE cCode = cCode " .$append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		$codeID = check_str($_REQUEST["cCode"]);
		
		$insert_map = array();

		$insert_map["cCode"]  = $codeID;
		$insert_map["cGroup"] = check_str($_REQUEST["cGroup"]);
		$insert_map["cName1"] = check_str($_REQUEST["cName1"]);
		$insert_map["cName2"] = check_str($_REQUEST["cName2"]);
		$insert_map["cName3"] = check_str($_REQUEST["cName3"]);
		$insert_map["cName4"] = check_str($_REQUEST["cName4"]);
		$insert_map["cName5"] = check_str($_REQUEST["cName5"]);
		$insert_map["cName6"] = check_str($_REQUEST["cName6"]);
		$insert_map["cName7"] = check_str($_REQUEST["cName7"]);

			run_sql_insert("codeinfo", $insert_map);
		break;


	case "edit":
		$codeID = check_str($_REQUEST["cCode"]);

		$update_map = array();

		$update_map["cGroup"] = check_str($_REQUEST["cGroup"]);
		$update_map["cName1"] = check_str($_REQUEST["cName1"]);
		$update_map["cName2"] = check_str($_REQUEST["cName2"]);
		$update_map["cName3"] = check_str($_REQUEST["cName3"]);
		$update_map["cName4"] = check_str($_REQUEST["cName4"]);
		$update_map["cName5"] = check_str($_REQUEST["cName5"]);
		$update_map["cName6"] = check_str($_REQUEST["cName6"]);
		$update_map["cName7"] = check_str($_REQUEST["cName7"]);

		$where_query = "cCode = \"" .$codeID. "\"";

		run_sql_update("codeinfo", $update_map, $where_query);

		break;

	case "del":
		$codeID = check_str($_REQUEST["id"]);

		$where_query = "cCode = \"" .$codeID. "\"";

		//저울 삭제
		run_sql_delete("codeinfo", $where_query);

		break;


	case "excel":
		$title = "상세 옵션 관리";

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
			
			$append_query = "AND cCode = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND cCode = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM codeinfo WHERE cCode = cCode " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("그룹명", "cGroup", "STR", "center"),
			array("속성1", "cName1", "STR", "center"),
			array("속성2", "cName2", "STR", "center"),
			array("속성3", "cName3", "STR", "center"),
			array("속성4", "cName4", "STR", "center"),
			array("속성5", "cName5", "STR", "center"),
			array("속성6", "cName6", "STR", "center"),
			array("속성7", "cName7", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>