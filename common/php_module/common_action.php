<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_tree":
		$search = isset($_REQUEST["search"]) ? check_str($_REQUEST["search"]) : "";

        // $select_query = "SELECT f.fFarmid, f.fName, IFNULL(fd.fdFarmid, '') AS fdFarmid, IFNULL(fd.fdDongid, '') AS fdDongid, IFNULL(fd.fdName, '') AS fdName, be.beStatus, cm.* FROM farm AS f
        //                 LEFT JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid
        //                 LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid
        //                 LEFT JOIN 
        //                     (SELECT cmFarmid, cmDongid, MAX(cmCode) AS maxCode, MAX(cmIndate) AS maxIndate, 
        //                     IF(Max(cmOutdate) < MAX(cmIndate), '', Max(cmOutdate)) AS maxOutdate FROM comein_master GROUP BY cmFarmid, cmDongid)
        //                 AS cm ON cm.cmFarmid = fd.fdFarmid AND cm.cmDongid = fd.fdDongid";
        $select_query = "SELECT f.fFarmid, f.fName, IFNULL(fd.fdFarmid, '') AS fdFarmid, IFNULL(fd.fdDongid, '') AS fdDongid, IFNULL(fd.fdName, '') AS fdName, be.beStatus, cm.* FROM farm AS f
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = f.fFarmid
                        LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = fd.fdFarmid AND be.beDongid = fd.fdDongid
                        LEFT JOIN comein_master AS cm ON cm.cmCode = be.beComeinCode";

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

            $tree_map[$farm_key][$dong_key] = $row["fdName"] . "|" . ($row["beStatus"] == "O" ? "출하" : "입추") . "|" . $row["cmCode"] . "|" . $row["cmIndate"] . "|" . $row["cmOutdate"] . "|" . $row["cmIntype"];
        }

        $response = $tree_map;

		echo json_encode($response);

		break;
}

?>