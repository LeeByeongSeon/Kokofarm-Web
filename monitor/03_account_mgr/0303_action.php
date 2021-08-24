<?

include_once("../common/php_module/common_func.php");

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
			
			$append_query = "AND mgrID = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND mgrID = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM manager WHERE mgrID = mgrID ". $append_query;
        
		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":

		$insert_map = array();

		$insert_map["mgrID"] 		= check_str($_REQUEST["mgrID"]);
		$insert_map["mgrPW"] 		= check_str($_REQUEST["mgrPW"]);
		$insert_map["mgrGroupName"] = check_str($_REQUEST["mgrGroupName"]);
		$insert_map["mgrName"]      = check_str($_REQUEST["mgrName"]);
		$insert_map["mgrEmail"] 	= check_str($_REQUEST["mgrEmail"]);
		$insert_map["mgrTel"] 	    = check_str($_REQUEST["mgrTel"]);
		$insert_map["mgrType"] 	    = check_str($_REQUEST["mgrType"]);
		$insert_map["mgrDate"] 	    = check_str($_REQUEST["mgrDate"]);

		run_sql_insert("manager", $insert_map);

		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);

		$update_map = array();

        $update_map["mgrPW"] 		= check_str($_REQUEST["mgrPW"]);
        $update_map["mgrGroupName"] = check_str($_REQUEST["mgrGroupName"]);
        $update_map["mgrName"]      = check_str($_REQUEST["mgrName"]);
        $update_map["mgrEmail"] 	= check_str($_REQUEST["mgrEmail"]);
        $update_map["mgrTel"] 	    = check_str($_REQUEST["mgrTel"]);
        $update_map["mgrType"] 	    = check_str($_REQUEST["mgrType"]);
        $update_map["mgrDate"] 	    = check_str($_REQUEST["mgrDate"]);

		$where_query = "mgrID = \"" .$pk. "\" ";

		run_sql_update("manager", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);

		$where_query = "mgrID = \"" .$pk. "\" ";

		//농장 계정 삭제
		run_sql_delete("manager", $where_query);

		break;


	case "excel":
		$title = "관리자 계정 관리";

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
			
			$append_query = "AND mgrID = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND mgrID = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM manager WHERE mgrID = mgrID ". $append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*관리자 정보*/
			array("번호", "No", "INT", "center"),
			array("아이디", "mgrID", "STR", "center"),
			array("비밀번호", "mgrPW", "STR", "center"),
			array("계열회사", "mgrGroupName", "STR", "center"),
			array("성명", "mgrName", "STR", "center"),
			array("전화번호", "mgrTel", "STR", "center"),
			array("이메일", "mgrEmail", "STR", "center"),
			array("계정구분", "mgrType", "STR", "center"),
			array("등록일자", "mgrDate", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>