

<form id="redirec_form" action="0101.php" method="post">

<?
	include_once("../common/php_module/common_func.php");

	$key = check_str($_REQUEST["key"]);
	$id = "kk0000";

	switch($key){	//p - 3 (id ^ 3)
		case "p34913":
			$id = "kk0017";
			break;
		case "p3157464":
			$id = "kk0054";
			break;
		case "p3166375":
			$id = "kk0055";
			break;
	}

	if($id != "kk0000"){
		$query = "SELECT * FROM farm WHERE fID = '".$id."';";
	
		$result = get_select_data($query);

		echo "<input type='hidden' name='userID' value='".$result[0]["fID"]."'>";
		echo "<input type='hidden' name='userPW' value='".$result[0]["fPW"]."'>";
	}
	else{
		echo "<input type='hidden' name='userID' value='kk0000'>";
		echo "<input type='hidden' name='userPW' value='0000'>";
	}

?>

</form>

<script type="text/javascript">
    document.getElementById('redirec_form').submit();
</script>