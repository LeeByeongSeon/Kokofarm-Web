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
			
			$append_query = "AND siFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND siDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT si.*, CONCAT(siFarmid, '|', siDongid, '|', siCellid) AS pk, fd.fdName FROM set_iot_cell AS si
						JOIN farm_detail AS fd ON fd.fdFarmid = si.siFarmid AND fd.fdDongid = si.siDongid 
						WHERE siFarmid = siFarmid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["siFarmid"]);
		$dongID = sprintf('%02d', check_str($_REQUEST["siDongid"]));
		$cellID = sprintf('%02d', check_str($_REQUEST["siCellid"]));

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = \"" .$farmID. "\" AND fdDongid = \"" .$dongID. "\";";

		$insert_map = array();

		if(get_select_count($check_query) > 0){
			$insert_map["siFarmid"] = $farmID;
			$insert_map["siDongid"] = $dongID;
			$insert_map["siCellid"] = $cellID;
			$insert_map["siVersion"] = check_str($_REQUEST["siVersion"]);
			$insert_map["siFirmware"] = check_str($_REQUEST["siFirmware"]);
			$insert_map["siDate"] = check_str($_REQUEST["siDate"]);
			$insert_map["siHaveTemp"] = check_str($_REQUEST["siHaveTemp"]);
			$insert_map["siHaveHumi"] = check_str($_REQUEST["siHaveHumi"]);
			$insert_map["siHaveCo2"] = check_str($_REQUEST["siHaveCo2"]);
			$insert_map["siHaveNh3"] = check_str($_REQUEST["siHaveNh3"]);

			run_sql_insert("set_iot_cell", $insert_map);
		}
		break;


	case "edit":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$cellID = $keys[2];

		$update_map = array();

		$update_map["siVersion"] = check_str($_REQUEST["siVersion"]);
		$update_map["siFirmware"] = check_str($_REQUEST["siFirmware"]);
		$update_map["siDate"] = check_str($_REQUEST["siDate"]);
		$update_map["siHaveTemp"] = check_str($_REQUEST["siHaveTemp"]);
		$update_map["siHaveHumi"] = check_str($_REQUEST["siHaveHumi"]);
		$update_map["siHaveCo2"] = check_str($_REQUEST["siHaveCo2"]);
		$update_map["siHaveNh3"] = check_str($_REQUEST["siHaveNh3"]);

		$where_query = "siFarmid = \"" .$farmID. "\" AND siDongid = \"" .$dongID. "\" AND siCellid = \"" .$cellID . "\"";

		run_sql_update("set_iot_cell", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$cellID = $keys[2];

		$where_query = "siFarmid = \"" .$farmID. "\" AND siDongid = \"" .$dongID. "\" AND siCellid = \"" .$cellID . "\"";

		//저울 삭제
		run_sql_delete("set_iot_cell", $where_query);

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
			
			$append_query = "AND siFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND siDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}

		//jqgrid 출력
		$select_query = "SELECT si.*, CONCAT(siFarmid, '|', siDongid, '|', siCellid) AS pk, fd.fdName FROM set_iot_cell AS si
						JOIN farm_detail AS fd ON fd.fdFarmid = si.siFarmid AND fd.fdDongid = si.siDongid 
						WHERE siFarmid = siFarmid " .$append_query. " ORDER BY " .$sidx. " " .$sord;

		$field_data = array(
			/*농가 정보*/
			array("번호", "No", "INT", "center"),
			array("농장ID", "siFarmid", "STR", "center"),
			array("동ID", "siDongid", "STR", "center"),
			array("동 이름", "fdName", "STR", "center"),
			array("저울ID", "siCellid", "STR", "center"),
			array("저울버전", "siVersion", "STR", "center"),
			array("펌웨어버전", "siFirmware", "STR", "center"),
			array("설치일자", "siDate", "STR", "center"),
			array("온도센서 유무", "siHaveTemp", "STR", "center"),
			array("습도센서 유무", "siHaveHumi", "STR", "center"),
			array("CO2센서 유무", "siHaveCo2", "STR", "center"),
			array("NH3센서 유무", "siHaveNh3", "STR", "center"),
		);

		convert_excel(get_select_data($select_query), $field_data, $title, $append_query);
		break;
}

?>