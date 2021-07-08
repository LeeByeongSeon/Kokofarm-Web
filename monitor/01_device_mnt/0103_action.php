<?
include_once("../../common/php_module/common_func.php");

$response = array();

// 어떤 작업인지 가져옴
$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

$append_query = "";

switch($oper){

    case "get_camera_grid":

        $comm = $_REQUEST["comm"];

        $select_sql = "SELECT sc.*, fd.fdName, be.beIPaddr, be.beStatus, be.beAvgWeight, be.beDays FROM set_camera AS sc
                        JOIN buffer_sensor_status AS be ON be.beFarmid = sc.scFarmid AND be.beDongid = sc.scDongid
                        JOIN farm_detail AS fd ON fd.fdFarmid = sc.scFarmid AND fd.fdDongid = sc.scDongid ";

        switch($comm){
            default : 
                $select_sql .= "WHERE sc.scFarmid = \"" .$comm. "\"";
                break;

            case "all":
                break;
            
            case "":
            case "in":
                $select_sql .= "WHERE be.beStatus != \"O\"";
                break;

            case "out":
                $select_sql .= "WHERE be.beStatus = \"O\"";
                break;
        }

        $select_sql .= " ORDER BY fd.fdName ASC";
        $result = get_select_data($select_sql);

        $camera_grid_data = "";
        foreach($result as $row){
            $name = $row["fdName"];
            $avg_weight = number_format($row["beAvgWeight"], 1);

            $img_url = "../../common/php_module/camera_func.php?ip=" .$row["beIPaddr"]. "&port=" .$row["scPort"]. "&url=" .urlencode($row["scUrl"]). "&id=" .$row["scId"]. "&pw=" .$row["scPw"];
            $camera_grid_data .= "<div class='col-md-3'>
                                    <img src='" .$img_url. "' width='100%' onError=\" $(this).attr('src','../images/noimage.jpg');\" onClick=\"camera_popup('" .$name. "','" .$img_url. "'); \">
                                    <p class='alert alert-" .($row["beStatus"] == "O" ? "danger" : "success"). "'>
                                        <span class='fa fa-home'></span>&nbsp; " .$name. "
										<span class='pull-right'>&nbsp;&nbsp;&nbsp;
                                            <span class='fa fa-camera' style='cursor:pointer' onClick=\"camera_popup('" .$name. "','" .$img_url. "'); \"></span>
                                        </span>
										<span class='pull-right'>&nbsp;&nbsp;&nbsp;
                                            <span class='fa fa-clock-o'></span>&nbsp;일령: " .$row["beDays"]. "
                                        </span>
										<span class='pull-right'>
                                            <span class='fa  fa-bar-chart-o'></span>&nbsp;평체:" .$avg_weight. "g
                                        </span>
									</p>
                                </div>";
        }

        $response["camera_grid_data"] = $camera_grid_data;

        break;

}

echo json_encode($response);
?>