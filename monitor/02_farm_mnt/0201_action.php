<?

include_once("../common/php_module/common_func.php");

$mgr_id    = $_SESSION["mgr_id"];
$mgr_name  = $_SESSION["mgr_name"];
$mgr_type  = $_SESSION["mgr_type"];
$mgr_group = $_SESSION["mgr_group"];

if(strlen($mgr_id)<=3 || strlen($mgr_name)<=3 || strlen($mgr_type)<=3 || strlen($mgr_group)<=3){
    echo ("<script>location.href='../00_login/index.php'</script>");
};

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

// cmCode에서 농장, 동 id 추출
if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];
    $id = explode("_", $code)[1];
    $farmID = substr($id, 0, 6);
    $dongID = substr($id, 6);
};

switch($oper){

	default:
		$page  = check_str($_REQUEST['page']); // jqGrid의 page 속성의 값
		$limit = check_str($_REQUEST['rows']); // jqGrid의 rowNum 속성의 값
		$sidx  = check_str($_REQUEST['sidx']); // jqGrid의 sortname 속성의 값
		$sord  = check_str($_REQUEST['sord']); // jqGrid의 sortorder 속성의 값

		break;

	case "get_data":
		$select_query = "SELECT fd.*, cm.* FROM farm_detail AS fd
						JOIN comein_master AS cm ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
						WHERE fdFarmid = \"$farmID\" AND fdDongid = \"$dongID\"";
		
		$select_data = get_select_data($select_query);

		$json_map = array();

		foreach($select_data as $val){
			$json_map[] = array(
				"gps_lat" => $val["fdGpslat"];
				"gps_lng" => $val["fdGpslng"];
			);
		}

		$response["json_map"] = $json_map;
		
		break;
};

?>