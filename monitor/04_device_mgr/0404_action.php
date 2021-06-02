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
			
			$append_query = "AND sfFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND sfDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(sfFarmid, '|', sfDongid) AS pk FROM set_feeder AS sf 
                        JOIN set_outsensor AS so ON so.soFarmid = sf.sfFarmid AND so.soDongid = sf.sfDongid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

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
			
            run_sql_insert("set_feeder", $insert_map);

            $is_out = check_str($_REQUEST["sfoutsensor"]);

            if($is_out == "y"){
                $out_map = array();
                $out_map["soFarmid"] = $farmID;
                $out_map["soDongid"] = $dongID;

                run_sql_insert("set_outsensor", $out_map);
            }

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
        $update_map["sfoutsensor"]  = check_str($_REQUEST["sfoutsensor"]);

		$where_query = "sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";

		run_sql_update("set_feeder", $update_map, $where_query);

        $is_out = check_str($_REQUEST["sfoutsensor"]);

        if($is_out == "n"){
            $out_map = array();
            $out_map["soFarmid"] = $farmID;
            $out_map["soDongid"] = $dongID;

            run_sql_update("set_feeder", $update_map, $where_query);
        }

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];

		$where_query = "sfFarmid = \"" .$farmID. "\" AND sfDongid = \"" .$dongID. "\"";
		//plc 삭제
		run_sql_delete("set_feeder", $where_query);

		break;


	case "excel":
		$title = "급이 / 급수 현황";

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
		$select_query = "SELECT *, CONCAT(sfFarmid, '|', sfDongid) AS pk FROM set_feeder WHERE sfFarmid = sfFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "sfFarmid", "STR", "center"),
			array("동ID", "sfDongid", "STR", "center"),
            array("사료빈 총 용량", "sfFeedMax", "STR", "center"),
            array("유량 센서 최대 펄스 값", "sfWaterMax", "STR", "center")
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>