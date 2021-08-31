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
			
			$append_query = "AND soFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND soDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT so.*, CONCAT(soFarmid, '|', soDongid) AS pk, fd.fdName FROM set_outsensor AS so 
                        JOIN farm_detail AS fd ON fd.fdFarmid = so.soFarmid AND fd.fdDongid = so.soDongid 
						WHERE so.soFarmid = so.soFarmid " .$append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["soFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["soDongid"]));

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["soFarmid"]     = $farmID;
			$insert_map["soDongid"]     = $dongID;
			$insert_map["soDate"]    	= date("Y-m-d H:i:s");
			
            run_sql_insert("set_outsensor", $insert_map);

		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$update_map = array();

		$update_map["soDate"]    	= check_str($_REQUEST["soDate"]);

		$where_query = "soFarmid = \"" .$farmID. "\" AND soDongid = \"" .$dongID. "\"";

		run_sql_update("set_outsensor", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$where_query = "soFarmid = \"" .$farmID. "\" AND soDongid = \"" .$dongID. "\"";
		//plc 삭제
		run_sql_delete("set_outsensor", $where_query);

		break;


	case "excel":
		$title = "급이/급수/외기 현황";

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
			
			$append_query = "AND sfFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND sfDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT sf.sfFarmid, sf.sfDongid, fd.fdName, sf.sfFeedMax, sf.sfWaterMax, sf.sfDate, so.soDate, CONCAT(sf.sfFarmid, '|', sf.sfDongid) AS pk FROM set_feeder AS sf 
						LEFT JOIN set_outsensor AS so ON so.soFarmid = sf.sfFarmid AND so.soDongid = sf.sfDongid 
						JOIN farm_detail AS fd ON fd.fdFarmid = sf.sfFarmid AND fd.fdDongid = sf.sfDongid 
						WHERE sfFarmid = sfFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "sfFarmid", "STR", "center"),
			array("동ID", "sfDongid", "STR", "center"),
			array("동ID", "fdName", "STR", "center"),
            array("사료빈 총 용량", "sfFeedMax", "STR", "center"),
            array("유량 센서 최대 펄스 값", "sfWaterMax", "STR", "center"),
			array("급이/급수 설치일", "sfDate", "STR", "center"),
			array("외기환경 설치일", "soDate", "STR", "center"),
		);

		convert_excel(get_select_data($select_query), $field_data, $title, $append_query, true);
		break;
}

?>