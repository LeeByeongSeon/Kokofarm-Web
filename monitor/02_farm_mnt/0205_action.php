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
		
		// 트리뷰 선택
		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND rcFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND rcDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}
		
		// 검색창 입력
		if(isset($_REQUEST["search_data"])){
			$search_data = $_REQUEST["search_data"];
			$search_json = json_decode(stripslashes($search_data), true);

			$append_query .= $search_json["search_stat"] != "" ? " AND rcStatus LIKE \"%" .(explode("(", $search_json["search_stat"])[0]). "%\"" : "";
			$append_query .= $search_json["search_request"] != "" ? " AND rcCommand LIKE \"%" .(explode("(", $search_json["search_request"])[0]). "%\"" : "";
			$append_query .= " AND (LEFT(rcRequestDate, 10) BETWEEN \"" .($search_json["search_sdate"] != "" ? $search_json["search_sdate"] : "2000-01-01"). "\" AND \"" .($search_json["search_edate"] != "" ? $search_json["search_edate"] : date("Y-m-d")). "\" )";
		}

		//jqgrid 출력
		$select_query = "SELECT rc.*, c.cName2, fd.fdName, cm.cmIndate, cm.cmIntype, CONCAT(rcFarmid, '|', rcDongid, '|', rcRequestDate) AS pk FROM request_calculate AS rc
						JOIN farm_detail AS fd ON fd.fdFarmid = rc.rcFarmid AND fd.fdDongid = rc.rcDongid
						JOIN comein_master AS cm ON cm.cmCode = rc.rcCode 
						JOIN codeinfo AS c ON c.cGroup = '진행상태' AND c.cName1 = rc.rcStatus 
						WHERE rcFarmid = rcFarmid " .$append_query;

		$total_len = get_select_count($select_query);

		$total_pages = $total_len > 0 ? ceil($total_len / $limit) : 0;
		$page = $page > $total_pages ? $total_pages : $page;
		$limit = $limit < 0 ? 0 : $limit;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
		if ($start < 0) {
			$start = 0;
		}

		//jqGrid 속성 및 Data return
		$response["page"] = $page;
		$response["total"] = $total_pages;
		$response["records"] = $total_len;
		$jqgrid_query = $select_query . " ORDER BY " .$sidx. " " .$sord. " LIMIT " .$start. ", " .$limit. ";";

		$result = get_select_data($jqgrid_query);

		foreach($result as $row){

			// 요청사항 및 변경사항 정리
			$change_status = "";
            $change_str = "";

            $checker = explode("|", $row["rcCommand"]);

            if(in_array("Day", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevDate"] . " -> " . $row["rcChangeDate"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Day(일령)";
            }

            if(in_array("Lst", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevLst"] . " -> " . $row["rcChangeLst"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Lst(축종)";
            }

            if(in_array("Opt", $checker)){
                $change_str .= (strlen($change_str) > 2 ? "<br>" : "") . $row["rcPrevRatio"] . " -> " . $row["rcChangeRatio"];
                $change_status .= (strlen($change_status) > 2 ? "<br>" : "") . "Opt(재산출)";
            }

			$row["rcCommand"] = $change_status;
			$row["rcChange"] = $change_str;

			// 진행 상태 코멘트 추가
			$row["rcStatus"] .= "(" . $row["cName2"] . ")";

			$response["print_data"][] = $row;
		}
        
		echo json_encode($response);

		break;

	case "add":

		// $insert_map = array();

		// $insert_map["rcFarmid"]     		= check_str($_REQUEST["rcFarmid"]);
		// $insert_map["rcDongid"]     		= check_str($_REQUEST["rcDongid"]);
		// $insert_map["rcRequestDate"]     	= date("Y-m-d H:i:S");

		break;

	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$request_date = $keys[2];

		$update_map = array();

        $update_map["rcChangeLst"]     = check_str($_REQUEST["rcChangeLst"]);
        $update_map["rcChangeDate"]     = check_str($_REQUEST["rcChangeDate"]);
        $update_map["rcMeasureDate"] 	= check_str($_REQUEST["rcMeasureDate"]);
        $update_map["rcMeasureVal"]      = check_str($_REQUEST["rcMeasureVal"]);

		$where_query = "rcFarmid = \"" .$farmID. "\" AND rcDongid = \"" .$dongID. "\" AND rcRequestDate = \"" .$request_date . "\"";

		run_sql_update("request_calculate", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$request_date = $keys[2];

		$where_query = "rcFarmid = \"" .$farmID. "\" AND rcDongid = \"" .$dongID. "\" AND rcRequestDate = \"" .$request_date . "\"";

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

		// 트리뷰 선택
		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND rcFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND rcDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}
		
		// 검색창 입력
		if(isset($_REQUEST["search_data"])){
			$search_data = $_REQUEST["search_data"];
			$search_json = json_decode(stripslashes($search_data), true);

			$append_query .= $search_json["search_stat"] != "" ? " AND rcStatus LIKE \"%" .(explode("(", $search_json["search_stat"])[0]). "%\"" : "";
			$append_query .= $search_json["search_request"] != "" ? " AND rcCommand LIKE \"%" .(explode("(", $search_json["search_request"])[0]). "%\"" : "";
			$append_query .= " AND (LEFT(rcRequestDate, 10) BETWEEN \"" .($search_json["search_sdate"] != "" ? $search_json["search_sdate"] : "2000-01-01"). "\" AND \"" .($search_json["search_edate"] != "" ? $search_json["search_edate"] : date("Y-m-d")). "\" )";
		}

		//jqgrid 출력
		$select_query = "SELECT rc.*, c.cName2, fd.fdName, cm.cmIndate, cm.cmIntype, CONCAT(rcFarmid, '|', rcDongid, '|', rcRequestDate) AS pk FROM request_calculate AS rc
						JOIN farm_detail AS fd ON fd.fdFarmid = rc.rcFarmid AND fd.fdDongid = rc.rcDongid
						JOIN comein_master AS cm ON cm.cmCode = rc.rcCode 
						JOIN codeinfo AS c ON c.cGroup = '진행상태' AND c.cName1 = rc.rcStatus 
						WHERE rcFarmid = rcFarmid " .$append_query;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("요청시간", "rcRequestDate", "STR", "center"),
			array("농장명", "fdName", "STR", "center"),
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

		convert_excel(get_select_data($select_query), $field_data, $title, $append_query);
		break;
}

?>