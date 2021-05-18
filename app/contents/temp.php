

<script src="../library/jquery/jquery.min.js"></script>						<!-- jQuery -->

<form id="redirec_form" action="index.php" method="post">

<?
	include_once("../common/common_func.php");

	$key = chkCHAR($_REQUEST["key"]);
	$id = "kk0000";

	switch($key){
		case "p34913":
			$id = "kk0017";
			break;
		case "p3157464":
			$id = "kk0054";
			break;
	}

	if($id != kk0000){
		$query = "SELECT * FROM farm WHERE fID = '".$id."';";
	
		$result = multiFindData($query, localDB_Conn);

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