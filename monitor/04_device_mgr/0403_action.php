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
			
			$append_query = "AND spFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND spDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT sp.*, bp.bpIPaddr, fd.fdName, CONCAT(spFarmid, '|', spDongid) AS pk FROM set_plc AS sp
						JOIN farm_detail AS fd ON fd.fdFarmid = sp.spFarmid AND fd.fdDongid = sp.spDongid 
                        JOIN buffer_plc_status AS bp ON bp.bpFarmid = sp.spFarmid AND bp.bpDongid = sp.spDongid 
						WHERE sp.spFarmid = sp.spFarmid " .$append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["spFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["spDongid"]));

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["spFarmid"] = $farmID;
			$insert_map["spDongid"] = $dongID;
			$insert_map["spURL"]    = check_str($_REQUEST["spURL"]);
			$insert_map["spPORT"]   = check_str($_REQUEST["spPORT"]);
			$insert_map["spPW"]     = check_str($_REQUEST["spPW"]);
			
			run_sql_insert("set_plc", $insert_map);

			$insert_map = array();

			$insert_map["bpFarmid"] = $farmID;
			$insert_map["bpDongid"] = $dongID;

			run_sql_insert("buffer_plc_status", $insert_map);
		}
	
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$update_map = array();

        $update_map["spURL"]    = check_str($_REQUEST["spURL"]);
        $update_map["spPORT"]   = check_str($_REQUEST["spPORT"]);
        $update_map["spPW"]     = check_str($_REQUEST["spPW"]);

		$where_query = "spFarmid = \"" .$farmID. "\" AND spDongid = \"" .$dongID. "\"";

		run_sql_update("set_plc", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$where_query = "spFarmid = \"" .$farmID. "\" AND spDongid = \"" .$dongID. "\"";
		run_sql_delete("set_plc", $where_query);

		$where_query = "bpFarmid = \"" .$farmID. "\" AND bpDongid = \"" .$dongID. "\"";
		run_sql_delete("buffer_plc_status", $where_query);

		break;


	case "excel":
		$title = "PLC 현황";

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
			
			$append_query = "AND spFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND spDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT sp.*, bp.bpIPaddr, fd.fdName, CONCAT(spFarmid, '|', spDongid) AS pk FROM set_plc AS sp
						JOIN farm_detail AS fd ON fd.fdFarmid = sp.spFarmid AND fd.fdDongid = sp.spDongid 
						JOIN buffer_plc_status AS bp ON bp.bpFarmid = sp.spFarmid AND bp.bpDongid = sp.spDongid 
						WHERE sp.spFarmid = sp.spFarmid  " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "spFarmid", "STR", "center"),
			array("동ID", "spDongid", "STR", "center"),
            array("동 이름", "fdName", "STR", "center"),
            array("IPAddr", "bpIPaddr", "STR", "center"),
            array("URL(IP, DDNS)", "spURL", "STR", "center"),
            array("Port", "spPORT", "STR", "center"),
            array("PW", "spPW", "STR", "center"),
		);

		convert_excel(get_select_data($select_query), $field_data, $title, $append_query, true);
		break;
}

?>