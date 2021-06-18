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
			
			$append_query = "AND rcFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND rcDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(dmFarmid, '|', dmDongid, '|', dmDate) AS pk FROM defect_manage WHERE dmFarmid = dmFarmid " .$append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["dmFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["dmDongid"]));
		$dateID = check_str($_REQUEST["dmDate"]);

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["dmFarmid"]    = $farmID;
			$insert_map["dmDongid"]    = $dongID;
			$insert_map["dmDate"]      = $dateID;
			$insert_map["dmStatus"]    = check_str($_REQUEST["dmStatus"]);
			$insert_map["dmWrite"]     = check_str($_REQUEST["dmWrite"]);
			$insert_map["dmDefect"]    = check_str($_REQUEST["dmDefect"]);
			$insert_map["dmDeviceVer"] = check_str($_REQUEST["dmDeviceVer"]);
			$insert_map["dmProblem"]   = check_str($_REQUEST["dmProblem"]);
			$insert_map["dmCause"]     = check_str($_REQUEST["dmCause"]);
			$insert_map["dmAction"]    = check_str($_REQUEST["dmAction"]);
			$insert_map["dmOthers"]    = check_str($_REQUEST["dmOthers"]);
			$insert_map["dmActor"]     = check_str($_REQUEST["dmActor"]);

			run_sql_insert("defect_manage", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$dateID = $keys[2];

		$update_map = array();

        $update_map["dmStatus"]    = check_str($_REQUEST["dmStatus"]);
        $update_map["dmWrite"]     = check_str($_REQUEST["dmWrite"]);
        $update_map["dmDefect"]    = check_str($_REQUEST["dmDefect"]);
        $update_map["dmDeviceVer"] = check_str($_REQUEST["dmDeviceVer"]);
        $update_map["dmProblem"]   = check_str($_REQUEST["dmProblem"]);
        $update_map["dmCause"]     = check_str($_REQUEST["dmCause"]);
        $update_map["dmAction"]    = check_str($_REQUEST["dmAction"]);
        $update_map["dmOthers"]    = check_str($_REQUEST["dmOthers"]);
        $update_map["dmActor"]     = check_str($_REQUEST["dmActor"]);

		$where_query = "dmFarmid = \"" .$farmID. "\" AND dmDongid = \"" .$dongID. "\" AND dmDate = \"" .$dateID . "\"";

		run_sql_update("defect_manage", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$dateID = $keys[2];

		$where_query = "dmFarmid = \"" .$farmID. "\" AND dmDongid = \"" .$dongID. "\" AND dmDate = \"" .$dateID . "\"";

		//저울 삭제
		run_sql_delete("defect_manage", $where_query);

		break;


	case "excel":
		$title = "결함 및 AS 관리";

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
			
			$append_query = "AND dmFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND dmDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(dmFarmid, '|', dmDongid, '|', dmDate) AS pk FROM defect_manage
                        WHERE dmFarmid = dmFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("작성일", "dmDate", "STR", "center"),
			array("조치상태", "dmStatus", "STR", "center"),
			array("농장ID", "dmFarmid", "STR", "center"),
			array("동ID", "dmDongid", "STR", "center"),
			array("작성 구분", "dmWrite", "STR", "center"),
			array("결함 구분", "dmDefect", "STR", "center"),
			array("발생일", "dmStartDate", "STR", "center"),
			array("발생 장치(존재 시 작성)", "dmDevice", "STR", "center"),
			array("버전(제품)", "dmDeviceVer", "STR", "center"),
			array("문제점(현상)", "dmProblem", "STR", "center"),
			array("원인(추정)", "dmCause", "STR", "center"),
			array("조치내용", "dmAction", "STR", "center"),
			array("기타", "dmOthers", "STR", "center"),
			array("담당자", "dmActor", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>