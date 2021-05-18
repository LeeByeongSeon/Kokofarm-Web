<?
	$tableTitle=$_REQUEST["tableTitle"];		//테이블 제목
	$tableSubTitle=$_REQUEST["tableSubTitle"];		//테이블 부제
	$tableHTML= $_REQUEST["tableHTML"];			//테이블 자료


	$titleColspan=substr_count($tableHTML,"<th")-2-14;
	$fileName=rawurlencode($tableTitle);				//IE 파일명 한글깨짐
	///$fileName=iconv('utf-8','euc-kr',$tableTitle);	//IE 파일명 한글깨짐 현상

	header("Expires: 0");
	header("Content-Type: application/vnd.ms-excel;charset=utf-8");
	//header("Content-Type: application/octet-stream");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Disposition: attachment;filename=\"" . date('Ymd') . "_" . $fileName . ".xls\"" );

	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>";
	echo "<html>";
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	echo "</head>";
	echo "<body style='border:solid 0.1pt #CCCCCC;font-size:14px'>";
	echo "<style> table th {background:#A0B3B3;font-weight:normal; text-align:center;color:white} </style>";
	echo "<table border='1' style='width:100%;font-size:14px'><tr><th>출력내용</th><td colspan='$titleColspan'>$tableSubTitle</td></tr><tr><th>출력일시</th><td style=\"mso-number-format:'\@'\" colspan='$titleColspan'>" . date('Y-m-d H:i:s') . "</td></tr></table><br>";

	$prnTable="<table table border='1' style='width:100%;font-size:14px'>";
	$prnTable .=$tableHTML;
	$prnTable .="</table>";

	echo $prnTable;
	echo "</body>";
	echo "</html>";

?>