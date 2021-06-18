<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_tree":
		$search = isset($_REQUEST["search"]) ? check_str($_REQUEST["search"]) : "";

		// $select_query = "SELECT f.fFarmid, f.fName, IFNULL(fd.fdFarmid, '') AS fdFarmid, IFNULL(fd.fdDongid, '') AS fdDongid, IFNULL(fd.fdName, '') AS fdName, cm.* FROM farm AS f
        //                 LEFT JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid
        //                 LEFT JOIN comein_master AS cm ON cm.cmFarmid = fd.fdFarmid AND cm.cmDongid = fd.fdDongid AND (cmOutdate is NULL OR cmOutdate = '2000-01-01 00:00:00')";

        $select_query = "SELECT f.fFarmid, f.fName, IFNULL(fd.fdFarmid, '') AS fdFarmid, IFNULL(fd.fdDongid, '') AS fdDongid, IFNULL(fd.fdName, '') AS fdName, be.beStatus FROM farm AS f
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid
                        LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid";

        $append_query = "";
        if($search != ""){
            $append_query = " WHERE f.fName LIKE '%" .$search. "%'";
        }

        //jqgrid 출력
        $select_query .= $append_query . " ORDER BY fName ASC";

        $result = get_select_data($select_query);

        $tree_map = array();

        // {KF0006|농장명 : {"KF0006|01":동명}, ...} 으로 파싱
        foreach($result as $row){

            $farm_key = $row["fFarmid"] . "|" . $row["fName"];

            $dong_key = $row["fdFarmid"] . "|" . $row["fdDongid"];

            if(empty($row["fdFarmid"]) || empty($row["fdDongid"]) || empty($row["fdName"])){
                $tree_map[$farm_key] = array();
                continue;
            }

            $tree_map[$farm_key][$dong_key] = $row["fdName"] . "|" . ($row["beStatus"] == "O" ? "출하" : "입추");
        }

        $reponse = $tree_map;

		echo json_encode($reponse);

		break;
}

?>