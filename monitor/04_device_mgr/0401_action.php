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
		$select_query = "SELECT *, CONCAT(siFarmid, siDongid, siCellid) AS pk FROM set_iot_cell WHERE siFarmid = siFarmid " .$append_query;

		$reponse = get_jqgrid_data($select_query, $page, $limit, $sidx, $sord);
		echo json_encode($reponse);

		break;

	case "add":
		//중복되는 농장ID가 있으면 추가 하지 않음
		$fID = check_str($_REQUEST["fID"]);
		$strSql = "SELECT * FROM farm WHERE fID = \"" . $fID . "\" ";

		if(get_select_count($strSql) <= 0){
			$fieldArr["fID"]=check_str($_REQUEST["fID"]);
			$fieldArr["fPW"]=check_str($_REQUEST["fPW"]);
			$fieldArr["fGroup"]=check_str($_REQUEST["fGroup"]);
			$fieldArr["fType"]=check_str($_REQUEST["fType"]);
			$fieldArr["fName"]=check_str($_REQUEST["fName"]);
			$fieldArr["fCEO"]=check_str($_REQUEST["fCEO"]);
			$fieldArr["fTel"]=check_str($_REQUEST["fTel"]);
			$fieldArr["fAddr"]=check_str($_REQUEST["fAddr"]);
			$fieldArr["fRegistNo"]=check_str($_REQUEST["fRegistNo"]);
			$fieldArr["fCode"]=check_str($_REQUEST["fCode"]);
			$fieldArr["fDate"]=date('Y-m-d');

			excuteQuery("INSERT", "farm", $fieldArr, "");
		}
		break;


	case "edit":
		$PK = check_str($_REQUEST["id"]);

		$fieldArr["fPW"]=check_str($_REQUEST["fPW"]);
		$fieldArr["fGroup"]=check_str($_REQUEST["fGroup"]);
		$fieldArr["fType"]=check_str($_REQUEST["fType"]);
		$fieldArr["fName"]=check_str($_REQUEST["fName"]);
		$fieldArr["fCEO"]=check_str($_REQUEST["fCEO"]);
		$fieldArr["fTel"]=check_str($_REQUEST["fTel"]);
		$fieldArr["fAddr"]=check_str($_REQUEST["fAddr"]);
		$fieldArr["fRegistNo"]=check_str($_REQUEST["fRegistNo"]);
		$fieldArr["fCode"]=check_str($_REQUEST["fCode"]);

		excuteQuery("UPDATE", "farm", $fieldArr, "fID=\"$PK\"");
		break;

	case "del":
		$PK = check_str($_REQUEST["id"]);

		//농장 삭제
		excuteQuery("DELETE", "farm", "", "fID=\"$PK\"");
		excuteQuery("DELETE", "set_plc", "", "spFarmid=\"$PK\"");
		excuteQuery("DELETE", "set_plc_detail", "", "sdFarmid=\"$PK\"");
		break;


	case "excel":
		$title="농장별 계정관리";

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