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
			
			$append_query = "AND mgrID = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND mgrID = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT * FROM manager WHERE mgrID = mgrID ". $append_query;
        
		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["mgrID"]);

		//$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\"";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["mgrID"] 		= $farmID;
			$insert_map["mgrPW"] 		= check_str($_REQUEST["fPW"]);
			$insert_map["mgrGroupName"] = check_str($_REQUEST["fGroupName"]);
			$insert_map["mgrName"]      = check_str($_REQUEST["fGroupid"]);
			$insert_map["mgrTel"] 	    = check_str($_REQUEST["fFarmid"]);
			$insert_map["mgrEmail"] 	= check_str($_REQUEST["fCeo"]);
			$insert_map["mgrType"] 	    = check_str($_REQUEST["fName"]);
			$insert_map["mgrDate"] 	    = check_str($_REQUEST["fName"]);

			run_sql_insert("manager", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);

		$update_map = array();

        $update_map["mgrPW"] 		= check_str($_REQUEST["fPW"]);
        $update_map["mgrGroupName"] = check_str($_REQUEST["fGroupName"]);
        $update_map["mgrName"]      = check_str($_REQUEST["fGroupid"]);
        $update_map["mgrTel"] 	    = check_str($_REQUEST["fFarmid"]);
        $update_map["mgrEmail"] 	= check_str($_REQUEST["fCeo"]);
        $update_map["mgrType"] 	    = check_str($_REQUEST["fName"]);
        $update_map["mgrDate"] 	    = check_str($_REQUEST["fName"]);

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
			
			$append_query = "AND scFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND scDongid = \"" . $select_ids[1] . "\"" : $append_query;
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