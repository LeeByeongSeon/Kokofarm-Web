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
		$select_query = "SELECT *, CONCAT(rcFarmid, '|', rcDongid, '|', rcRequestDate) AS pk
                         FROM request_calculate WHERE rcFarmid = rcFarmid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
        
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["rcFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["rcDongid"]));
		$rqstID = check_str($_REQUEST["rcRequestDate"]);
        //$rqstID = date("Y-m-d H:i:s", time());

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["rcFarmid"]      = $farmID;
			$insert_map["rcDongid"]      = $dongID;
			$insert_map["rcRequestDate"] = $rqstID;
			$insert_map["rcCommand"]     = check_str($_REQUEST["rcCommand"]);
			$insert_map["rcStatus"]      = check_str($_REQUEST["rcStatus"]);
			$insert_map["rcApproveDate"] = check_str($_REQUEST["rcApproveDate"]);
			$insert_map["rcPrevLst"]     = check_str($_REQUEST["rcPrevLst"]);
			$insert_map["rcChangeLst"]   = check_str($_REQUEST["rcChangeLst"]);
			$insert_map["rcPrevDate"]    = check_str($_REQUEST["rcPrevDate"]);
			$insert_map["rcChangeDate"]  = check_str($_REQUEST["rcChangeDate"]);
			$insert_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);
			$insert_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]);
			$insert_map["rcPrevWeight"]  = check_str($_REQUEST["rcPrevWeight"]);
			$insert_map["rcPrevRatio"]   = check_str($_REQUEST["rcPrevRatio"]);
			$insert_map["rcChangeRatio"] = check_str($_REQUEST["rcChangeRatio"]);
			$insert_map["rcFinishDate"]  = check_str($_REQUEST["rcFinishDate"]);

			run_sql_insert("request_calculate", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$rqstID = $keys[2];

		$update_map = array();

        $update_map["rcCommand"]     = check_str($_REQUEST["rcCommand"]);
        $update_map["rcStatus"]      = check_str($_REQUEST["rcStatus"]);
        $update_map["rcApproveDate"] = check_str($_REQUEST["rcApproveDate"]);
        $update_map["rcPrevLst"]     = check_str($_REQUEST["rcPrevLst"]);
        $update_map["rcChangeLst"]   = check_str($_REQUEST["rcChangeLst"]);
        $update_map["rcPrevDate"]    = check_str($_REQUEST["rcPrevDate"]);
        $update_map["rcChangeDate"]  = check_str($_REQUEST["rcChangeDate"]);
        $update_map["rcMeasureDate"] = check_str($_REQUEST["rcMeasureDate"]);
        $update_map["rcMeasureVal"]  = check_str($_REQUEST["rcMeasureVal"]);
        $update_map["rcPrevWeight"]  = check_str($_REQUEST["rcPrevWeight"]);
        $update_map["rcPrevRatio"]   = check_str($_REQUEST["rcPrevRatio"]);
        $update_map["rcChangeRatio"] = check_str($_REQUEST["rcChangeRatio"]);
        $update_map["rcFinishDate"]  = check_str($_REQUEST["rcFinishDate"]);

		$where_query = "rcFarmid = \"" .$farmID. "\" AND rcDongid = \"" .$dongID. "\" AND rcRequestDate = \"" .$rqstID . "\"";

		run_sql_update("request_calculate", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$rqstID = $keys[2];

		$where_query = "rcFarmid = \"" .$farmID. "\" AND rcDongid = \"" .$dongID. "\" AND rcRequestDate = \"" .$rqstID . "\"";

		//저울 삭제
		run_sql_delete("request_calculate", $where_query);

		break;


	case "excel":
		$title = "재산출 요청 관리";

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
			
			$append_query = "AND rcFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND rcDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(rcFarmid, '|', rcDongid, '|', rcRequestDate) AS pk FROM request_calculate
                        WHERE rcFarmid = rcFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("요청시간", "rcRequestDate", "STR", "center"),
			array("농장ID", "rcFarmid", "STR", "center"),
			array("동ID", "rcDongid", "STR", "center"),
			array("요청 사항", "rcCommand", "STR", "center"),
			array("진행 상태", "rcStatus", "STR", "center"),
			array("승인시간", "rcApproveDate", "STR", "center"),
			array("기존 축종", "rcPrevLst", "STR", "center"),
			array("변경 축종", "rcChangeLst", "STR", "center"),
			array("기존 입추시간", "rcPrevDate", "STR", "center"),
			array("변경 입추시간", "rcChangeDate", "STR", "center"),
			array("실측시간", "rcMeasureDate", "STR", "center"),
			array("실측값", "rcMeasureVal", "STR", "center"),
			array("기존 예측중량", "rcPrevWeight", "STR", "center"),
			array("기존 ratio", "rcPrevRatio", "STR", "center"),
			array("변경 ratio", "rcChangeRatio", "STR", "center"),
			array("완료시간", "rcFinishDate", "STR", "center"),
		);

		convert_excel($select_query, $field_data, $title, $append_query);
		break;
}

?>