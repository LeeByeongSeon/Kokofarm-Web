<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	default:
		$page = check_str($_REQUEST['page']); // jqGrid의 page 속성의 값
		$limit = check_str($_REQUEST['rows']);// jqGrid의 rowNum 속성의 값
		$sidx = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
		$sord = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

		//검색필드
		$append_query = "";

		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND scFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND scDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT sc.*, fdName, beIPaddr, CONCAT(scFarmid, '|', scDongid) AS pk FROM set_camera AS sc 
						JOIN farm_detail AS fd ON fd.fdFarmid = sc.scFarmid AND fd.fdDongid = sc.scDongid 
						JOIN buffer_sensor_status AS be ON be.beFarmid = sc.scFarmid AND be.beDongid = sc.scDongid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["scFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["scDongid"]));

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["scFarmid"] = $farmID;
			$insert_map["scDongid"] = $dongID;
			$insert_map["scPort"] = check_str($_REQUEST["scPort"]);
			$insert_map["scUrl"] = check_str($_REQUEST["scUrl"]);
			$insert_map["scId"] = check_str($_REQUEST["scId"]);
			$insert_map["scPw"] = check_str($_REQUEST["scPw"]);

			run_sql_insert("set_camera", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$update_map = array();

		$insert_map["scPort"] = check_str($_REQUEST["scPort"]);
		$insert_map["scUrl"] = check_str($_REQUEST["scUrl"]);
		$insert_map["scId"] = check_str($_REQUEST["scId"]);
		$insert_map["scPw"] = check_str($_REQUEST["scPw"]);

		$where_query = "scFarmid = \"" .$farmID. "\" AND scDongid = \"" .$dongID. "\"";

		run_sql_update("set_camera", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$where_query = "scFarmid = \"" .$farmID. "\" AND scDongid = \"" .$dongID. "\"";

		//저울 삭제
		run_sql_delete("set_camera", $where_query);

		break;


	case "excel":
		$title = "IoT저울 현황";

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
		$select_query = "SELECT sc.*, fdName, beIPaddr, CONCAT(scFarmid, '|', scDongid) AS pk FROM set_camera AS sc 
						JOIN farm_detail AS fd ON fd.fdFarmid = sc.scFarmid AND fd.fdDongid = sc.scDongid 
						JOIN buffer_sensor_status AS be ON be.beFarmid = sc.scFarmid AND be.beDongid = sc.scDongid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "scFarmid", "STR", "center"),
			array("동ID", "scDongid", "STR", "center"),
			array("동 이름", "fdName", "STR", "center"),
			array("접속 IP", "beIPaddr", "STR", "center"),
			array("접속 Port", "scPort", "STR", "center"),
			array("접속 URL", "scUrl", "STR", "center"),
			array("접속 ID", "scId", "STR", "center"),
			array("접속 PW", "scPw", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>