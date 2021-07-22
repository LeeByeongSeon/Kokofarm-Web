<?

include_once("../../common/php_module/common_func.php");
	
	$response = array();

	$oper = isset($_REQUEST["oper"]) ? $oper = check_str($_REQUEST["oper"]) : "";

	if(isset($_REQUEST["cmCode"])){
		$code = $_REQUEST["cmCode"];

		$result = get_feed_history($code, $oper);

		$response["chart_feed"] = $result["chart_feed"];
		$response["chart_water"] = $result["chart_water"];

		echo json_encode($response);
	
	};
?>