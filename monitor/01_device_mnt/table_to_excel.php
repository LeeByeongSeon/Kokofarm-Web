<?
$table_html  = $_REQUEST["table_html"];
$table_title = $_REQUEST["table_title"];

//var_dump($_REQUEST);

$file_name	 = rawurlencode($table_title);			 //IE 파일명 한글깨짐
//$file_name = iconv('utf-8','euc-kr',$table_title); //IE 파일명 한글깨짐 현상

header("Expires: 0");
header("Content-Type: application/vnd.ms-excel;charset=utf-8");
//header("Content-Type: application/octet-stream");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment;filename=\"" . date('Ymd') . "_" . $file_name . ".xls\"" );

echo $table_html;
?>