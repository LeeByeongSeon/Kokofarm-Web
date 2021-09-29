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
	case "get_inout_data": // 임시(?)

		$select_query = "SELECT COUNT(CASE WHEN beStatus='I' THEN 1 END) AS insu, COUNT(CASE WHEN beStatus='O' THEN 1 END) AS outsu FROM buffer_sensor_status";

		$select_data = get_select_data($select_query);

		$inout_data = array();

		if(!empty($select_data)){

			$row = $select_data[0];

			$inout_data[] = array(
				'f1' => $row["insu"],
				'f2' => "-",
				'f3' => "-",
				'f4' => $row["outsu"],
			);
		}

		$response["inout_data"] = $inout_data;

		echo json_encode($response);

		break;

	case "get_ho_data":

		$select_query = "SELECT cName1, COUNT(*) AS cnt FROM codeinfo AS c 
						 LEFT JOIN buffer_sensor_status AS be ON beAvgWeight BETWEEN cName2 AND cName3
						 WHERE c.cGroup = '중량호수' GROUP BY cName1";

		$select_data = get_select_data($select_query);

		$ho_data = array();

		if(!empty($select_data)){
			foreach($select_data as $row){
				if($row["cName1"] > 10){
					$ho_data[0]["f". $row["cName1"]] = $row["cnt"];
				}
			}
		};
		
		$response["ho_data"] = $ho_data;

		echo json_encode($response);

		break;

	case "get_map_data":

		$select_query = "SELECT fd.*, cm.*, be.beStatus FROM farm_detail AS fd
						 JOIN comein_master AS cm ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
						 JOIN buffer_sensor_status AS be ON fd.fdFarmid = be.beFarmid AND fd.fdDongid = be.beDongid";
		
		$select_data = get_select_data($select_query);

		$json_map = array();

		if(!empty($select_data)){
			foreach($select_data as $val){
				$json_map[] = array(
					"f_status" => $val["beStatus"],
					"f_farmid" => $val["fdFarmid"]. "|" .$val["fdDongid"],
					"f_name"   => $val["fdName"],
					"gps_lat"  => $val["fdGpslat"],
					"gps_lng"  => $val["fdGpslng"],
				);
			};
		};

		// var_dump($json_map);

		$response["json_map"] = $json_map;

		echo json_encode($response);

		break;

};

?>