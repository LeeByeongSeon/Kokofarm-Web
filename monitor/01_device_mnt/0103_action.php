<?
include_once("../../common/php_module/common_func.php");

$response=array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

$append_query = "";

switch($oper){
    //전체
	case "allCamera":
		//검색필드
		if(isset($_REQUEST["select"]) && $_REQUEST["select"] != ""){
			$select = $_REQUEST["select"];
			$select_ids = explode("|", $select);
			
			$append_query = "AND scFarmid = \"" . $select_ids[0] . "\"";

			$append_query = isset($select_ids[1]) ? $append_query . " AND scDongid = \"" . $select_ids[1] . "\"" : $append_query;
		}
        
		$select_sql =   "SELECT *,
                            (SELECT beIPaddr FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beIPaddr,
                            (SELECT beAvgWeight FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beAvgWeight,
                            (SELECT  IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) FROM comein_master WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND ( IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4) ) AS inTERM
                        FROM farm_detail,set_camera WHERE fdFarmid=scFarmid AND fdDongid=scDongid" .$append_query;

		$response = get_select_data($select_sql);

		$ipCamerasHTML="";
        if(!empty($response)){
            foreach($response as $Val){
                $farmName      = $Val["fdName"];
                $farmAvgWeight = number_format($Val["beAvgWeight"],1);
                $farmTerm      = $Val["inTERM"];		//일령
                $imgURL        = "../../common/php_module/camera_func.php?IP=" . $Val["beIPaddr"] . "&PORT=" . $Val["scPort"] . "&URL=" . urlencode($Val["scUrl"]) . "&ID=" . $Val["scId"] . "&PW=" . $Val["scPw"] . "&date=" . date('YmdHis');
                $ipCamerasHTML .="<div class='col-md-3'>
                                    <img src='$imgURL' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg');\">
                                    <p class='alert alert-info'>
										<span><span class='fa fa-home'></span>&nbsp;$farmName</span>
										<span class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='fa fa-camera' style='cursor:pointer' onClick=' actionBtn(\"$cameraURL\",\"$farmName\"); '></span></span>
									</p>
                                </div>";
            }
            $response["ipCameras"] = $ipCamerasHTML;
        }
		break;
    
    //입추
    case "inCamera":
		
		$select_sql =   "SELECT *,
                            (SELECT '입추' FROM comein_master WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND ( IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4) ) AS inType,
                            (SELECT beIPaddr FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beIPaddr,
                            (SELECT beAvgWeight FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beAvgWeight,
                            (SELECT  IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) FROM comein_master WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND ( IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4) ) AS inTERM
                        FROM farm_detail,set_camera WHERE fdFarmid=scFarmid AND fdDongid=scDongid" .$append_query;

		$response = get_select_data($select_sql);

		$ipCamerasHTML="";
        if(!empty($response)){
            foreach($response as $Val){
                $farmName      = $Val["fdName"];
                $farmAvgWeight = number_format($Val["beAvgWeight"],1);
                $farmTerm      = $Val["inTERM"];		//일령
                $imgURL        = "../../common/php_module/camera_func.php?IP=" . $Val["beIPaddr"] . "&PORT=" . $Val["scPort"] . "&URL=" . urlencode($Val["scUrl"]) . "&ID=" . $Val["scId"] . "&PW=" . $Val["scPw"] . "&date=" . date('YmdHis');
    
                if($Val["inType"]=="입추"){
                    $ipCamerasHTML .="<div class='col-md-3'>
                                        <img src='$imgURL' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg');\">
                                        <p class='alert alert-warning'>
                                            <span><span class='fa fa-home'></span>&nbsp;$farmName</span>
                                            <span class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='fa fa-camera' style='cursor:pointer' onClick=' cameraPopup(\"$farmName\",\"$farmAvgWeight\",\"$imgURL\",\"$farmTerm\"); '></span></span>
                                        </p>
                                    </div>";
                }
            }
            $response["ipCameras"] = $ipCamerasHTML;
        }

        break;
    
    //출하
    case "outCamera":
		
		$select_sql =   "SELECT *,
                            (SELECT '입추' FROM comein_master WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND ( IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4) ) AS inType,
                            (SELECT beIPaddr FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beIPaddr,
                            (SELECT beAvgWeight FROM buffer_sensor_status WHERE beFarmid=fdFarmid AND beDongid=fdDongid) as beAvgWeight,
                            (SELECT  IFNULL(DATEDIFF(current_date(),cmIndate)+1,0) FROM comein_master WHERE cmFarmid=fdFarmid AND cmDongid=fdDongid AND ( IFNULL(LENGTH(cmIndate),0)>=4 AND IFNULL(LENGTH(cmOutdate),0)<=4) ) AS inTERM
                        FROM farm_detail,set_camera WHERE fdFarmid=scFarmid AND fdDongid=scDongid" .$append_query;

		$response = get_select_data($select_sql);

		$ipCamerasHTML="";
        if(!empty($response)){
            foreach($response as $Val){
                $farmName      = $Val["fdName"];
                $farmAvgWeight = number_format($Val["beAvgWeight"],1);
                $farmTerm      = $Val["inTERM"];		//일령
                $imgURL        = "../../common/php_module/camera_func.php?IP=" . $Val["beIPaddr"] . "&PORT=" . $Val["scPort"] . "&URL=" . urlencode($Val["scUrl"]) . "&ID=" . $Val["scId"] . "&PW=" . $Val["scPw"] . "&date=" . date('YmdHis');
    
                if($Val["inType"]!="입추"){
                    $ipCamerasHTML .="<div class='col-md-3'>
                                        <img src='$imgURL' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg');\">
                                        <p class='alert alert-danger'>
                                            <span><span class='fa fa-home'></span>&nbsp;$farmName</span>
                                            <span class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='fa fa-camera' style='cursor:pointer' onClick=' cameraPopup(\"$farmName\",\"$farmAvgWeight\",\"$imgURL\",\"$farmTerm\"); '></span></span>
                                        </p>
                                    </div>";
                }
            }
            $response["ipCameras"] = $ipCamerasHTML;
        }
        
        break;
}

echo json_encode($response);
?>