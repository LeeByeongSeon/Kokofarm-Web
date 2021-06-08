<?

include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

switch($oper){
	case "get_table_data":

        $ref_data = get_select_data("SELECT * FROM codeinfo WHERE LEFT(cGroup, 2) = \"권고\"");
        $ref_map = array();

        foreach($ref_data as $val){
            $group = $val["cGroup"];
            $type = $val["cName1"];
            $day = $val["cName2"];
            
            //ex) [권고온도][육계][일령]{35,36,37,38}
            $ref_map[$group][$type][$day] = array($val["cName3"], $val["cName4"], $val["cName5"], $val["cName6"]);
        }
		
        $select_query = "SELECT cm.cmCode, cm.cmFarmid, cm.cmDongid, cm.cmIntype, fd.fdName,
                            IFNULL(DATEDIFF(current_date(), cm.cmIndate) + 1, 0) as days, 
                            be.beAvgWeight, be.beNetwork, bp.bpSensorDate, bp.bpDeviceDate, sf.sfFeedDate, sf.sfWaterDate, so.soSensorDate,
                            GROUP_CONCAT(siSensorDate separator '|') AS siSensorDate, GROUP_CONCAT(siTemp separator '|') AS siTemp, GROUP_CONCAT(siHumi separator '|') AS siHumi, 
                            GROUP_CONCAT(siCo2 separator '|') AS siCo2, GROUP_CONCAT(siNh3 separator '|') AS siNh3 
                        FROM comein_master AS cm
                        LEFT JOIN farm_detail AS fd ON fd.fdFarmid = cm.cmFarmid AND fd.fdDongid = cm.cmDongid
                        LEFT JOIN set_iot_cell AS si ON si.siFarmid = cm.cmFarmid AND si.siDongid = cm.cmDongid
                        LEFT JOIN buffer_sensor_status AS be ON be.beFarmid = cm.cmFarmid AND be.beDongid = cm.cmDongid
                        LEFT JOIN buffer_plc_status AS bp ON bp.bpFarmid = cm.cmFarmid AND bp.bpDongid = cm.cmDongid
                        LEFT JOIN set_feeder AS sf ON sf.sfFarmid = cm.cmFarmid AND sf.sfDongid = cm.cmDongid
                        LEFT JOIN set_outsensor AS so ON so.soFarmid = cm.cmFarmid AND so.soDongid = cm.cmDongid
                        WHERE (cmOutdate is NULL OR cmOutdate = '2000-01-01 00:00:00') 
                        GROUP BY cm.cmCode";
        
        $select_data = get_select_data($select_query);

        $table_data = array();

        foreach($select_data as $val){
            $table_data[] = array(
				'f1'  => $val["cmCode"],									//입출하코드
                'f2'  => $val["days"],									    //일령
				'f3'  => $val["fdName"],									//농장명
				'f4'  => $val["cmIntype"],									//축종

                'f5'  => $val["siSensorDate"],								//측정시간
                'f6'  => $val["siTemp"],									//온도
                'f7'  => $val["siHumi"],									//습도
                'f8'  => $val["siCo2"],									    //CO2
                'f9'  => $val["siNh3"],									    //NH3
                'f10'  => "test",									        //환경경보

                'f11'  => $val["beAvgWeight"],								//평균중량
                'f12'  => $val["beNetwork"],								//네트워크
                'f13'  => $val["bpDeviceDate"],								//PLC 제어
                'f14'  => $val["bpSensorDate"],								//PLC 환경
                'f15'  => $val["sfFeedDate"],								//급이-급수
                'f16'  => $val["soSensorDate"],								//외기환경
			);
        }

        $reponse["table_data"] = $table_data;

		echo json_encode($reponse);

		break;
}

?>