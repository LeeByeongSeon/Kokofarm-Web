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
			
			$append_query = "AND sfFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND sfDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT sf.*, CONCAT(sfFarmid, '|', sfDongid) AS pk, fd.fdName FROM set_feeder AS sf 
                        JOIN farm_detail AS fd ON fd.fdFarmid = sf.sfFarmid AND fd.fdDongid = sf.sfDongid 
						WHERE sf.sfFarmid = sf.sfFarmid " .$append_query;

		$response = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($response);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["sfFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["sfDongid"]));

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["sfFarmid"]     = $farmID;
			$insert_map["sfDongid"]     = $dongID;
			$insert_map["sfFeedMax"]    = check_str($_REQUEST["sfFeedMax"]);
			$insert_map["sfWaterMax"]   = check_str($_REQUEST["sfWaterMax"]);
			$insert_map["sfDate"]		= date("Y-m-d H:i:s");
			
            run_sql_insert("set_feeder", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$update_map = array();

        $update_map["sfFeedMax"]    = check_str($_REQUEST["sfFeedMax"]);
        $update_map["sfWaterMax"]   = check_str($_REQUEST["sfWaterMax"]);
        $update_map["sfDate"]  = check_str($_REQUEST["sfDate"]);

		$where_query = "sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";

		run_sql_update("set_feeder", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$where_query = "sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";

		run_sql_delete("set_feeder", $where_query);

		break;
}

?>