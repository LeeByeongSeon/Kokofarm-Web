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

		if(isset($_REQUEST["search_data"])){
			$search_data = $_REQUEST["search_data"];	
            $search_data = stripslashes($search_data);	
            $search_json = json_decode($search_data, true);
		}

		//jqgrid 출력
		$select_query = "SELECT *, CONCAT(siFarmid, '|', siDongid, '|', siCellid) AS pk FROM set_iot_cell WHERE siFarmid = siFarmid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//farm_detail을 확인 후 존재하면 insert
		$farmID = check_str($_REQUEST["siFarmid"]);
		$dongID = check_str($_REQUEST["siDongid"]);
		$cellID = check_str($_REQUEST["siCellid"]);

		$check_query = "SELECT * FROM farm_detail WHERE fdFarmid = " .$farmID. " AND fdDongid = " .$dongID. ";";

		$insert_map = array();

		if(get_select_count($check_query) > 1){
			foreach($REQUEST as $key => $val){
				if(substr($key, 0, 2) == "si"){
					$insert_map[$key] = check_str($val);
				}
			}

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

		$update_map["siVersion"] = check_str($_REQUEST["siDongid"]);
		$update_map["siFirmware"] = check_str($_REQUEST["siDongid"]);
		$update_map["siDate"] = check_str($_REQUEST["siDongid"]);
		$update_map["siHaveTemp"] = check_str($_REQUEST["siDongid"]);
		$update_map["siHaveHumi"] = check_str($_REQUEST["siDongid"]);
		$update_map["siHaveCo2"] = check_str($_REQUEST["siDongid"]);
		$update_map["siHaveNh3"] = check_str($_REQUEST["siDongid"]);

		$where_query = "siFarmid = " .$farmID. " AND siDongid = " .$dongID. " AND siCellid = " .$cellID;

		run_sql_update("set_iot_cell", $update_map, $where_query);

		break;

	case "del":
		$pk = check_str($_REQUEST["id"]);
		$keys = explode("|", $pk);

		$farmID = $keys[0];
		$dongID = $keys[1];
		$cellID = $keys[2];

		$where_query = "siFarmid = " .$farmID. " AND siDongid = " .$dongID. " AND siCellid = " .$cellID;

		//저울 삭제
		run_sql_delete("set_iot_cell", $where_query);

		break;


	case "excel":
		$title="IoT저울 현황";

		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=" . date('Ymd') . "_" . $title . ".xls");

		$sidx = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
		$sord = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

		//검색필드
		$append_sql="";

		if(isset($_REQUEST["search_data"])){
			$search_data=$_REQUEST["search_data"];	$search_data=stripslashes($search_data);	$search_json=json_decode($search_data,true);

			$src = $search_json["searchName"];
			if ($search_json["searchName"]!="") $append_sql .= " AND (fName LIKE '%" . $src . "%'  OR fID LIKE'%" . $src . "%' OR fTel LIKE'%" . $src . "%' OR fAddr LIKE '%" . $src . "%' OR fCEO LIKE '%" . $src . "%') ";
			if ($search_json["searchGroup"]!="") $append_sql .= " AND fGroup='" . $search_json["searchGroup"] . "' ";
			if ($search_json["searchAccount"]!="") $append_sql .= " AND fType='" . $search_json["searchAccount"] . "' ";
		}

		$fieldData=array(
			/*농가 정보*/
			array("번호","No","INT","center"),
			array("등록일자","fDate","STR","center"),
			array("관리그룹","fGroup","STR","center"),
			array("농가구분","fType","STR","center"),
			array("농장ID","fID","STR","left"),
			array("농장PW","fPW","STR","center"),
			array("농장명","fName","STR","left"),
			array("농장주","fCEO","STR","left"),
			array("전화번호","fTel","STR","center"),
			array("주소","fAddr","STR","left"),
			array("축산업등록번호","fRegistNo","STR","left"),
			array("농장등록코드","fCode","STR","left"),
		);
		
		$strSql="SELECT * FROM farm WHERE fID = fID " . $append_sql . " ORDER BY  $sidx  $sord ";
		convertExcel($strSql, $fieldData, $title, $append_sql);
		break;
}

?>