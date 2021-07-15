<?
	//*************************************************************
	// 명령 프로토콜
	// START    TARGET    COMM    LEN    DATA    CRC    END
	// AA		81		  53	  	                    EE
	// 
	// COMM		53 : 저울 원격 명령	54 : 제어기 원격 명령
	// LEN		DATA의 바이트 수
	// DATA		실제 명령 데이터
	// CRC		TARGET ~ DATA 까지 1바이트씩 XOR한 값
	//
	//*************************************************************

    const HEAD = "AA";
    const TARGET = "81";
    const TAIL = "EE";

    // 패킷 생성
    function make_packet($comm, $data){
        $ret = "";

        $len = strtoupper( sprintf("%02s", dechex( strlen($data) / 2 ) ) );

        $ret = $comm . $len . $data;

        $crc = TARGET;
        for($i=0; $i<=strlen($ret); $i+=2){
            $crc = make_crc($crc, substr($ret, $i, 2));
        }

        $ret = HEAD . TARGET . $ret . $crc . TAIL;
        return $ret;

    }

    
	
	//--------------------------------------------------------
	// 영점 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// $cellID : 저울번호		입력형식 : "01" 
	//--------------------------------------------------------
	function conv_itr_zero_set($farmID, $dongID, $cellID){
		$ret = "";
		$itr_head = "AA815405";
		$itr_comm = "46";		//ascii 코드 F = 0x46
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );	//저울 
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );
		$itr_cellID = get_cell($cellID, "3");

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm . $itr_cellID;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=16; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}
	
	//--------------------------------------------------------
	// 로그데이터 삭제 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_itr_log_delete($farmID, $dongID){
		$ret = "";
		$itr_head = "AA815304";
		$itr_comm = "53";		//ascii 코드 S = 0x53
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=14; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 원격업데이트 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_itr_ctrl_update($farmID, $dongID){
		$ret = "";
		$itr_head = "AA815304";
		$itr_comm = "55";		//ascii 코드 U = 0x53
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=14; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 통합제어기 펌웨어 확인 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_itr_ctrl_firmware_check($farmID, $dongID){
		$ret = "";
		$itr_head = "AA816D04";
		$itr_comm = "56";		//ascii 코드 V = 0x56
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=14; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 저울 펌웨어 확인 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_itr_cell_firmware_check($farmID, $dongID){
		return conv_remote_check("4D", $farmID, $dongID);
	}

	//--------------------------------------------------------
	// 팬설정 확인 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_fan_check($farmID, $dongID){
		return conv_remote_check("4F", $farmID, $dongID);
	}

	//--------------------------------------------------------
	// 통합제어기 펌웨어 업데이트 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// "57"
	//--------------------------------------------------------
	function conv_update_firmware($farmID, $dongID){
		return conv_remote_setting("57", $farmID, $dongID);
	}

	//--------------------------------------------------------
	// 재부팅 명령 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// "52"
	//--------------------------------------------------------
	function conv_reboot($farmID, $dongID){
		return conv_remote_setting("52", $farmID, $dongID);
	}

	//--------------------------------------------------------
	// 팬 동작온도 설정 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// "54"
	//--------------------------------------------------------
	function conv_fan_temp_start($farmID, $dongID, $temp){
		return conv_remote_setting_with_temp("54", $farmID, $dongID, $temp);
	}

	//--------------------------------------------------------
	// 팬 정지온도 설정 변환 함수
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// "4F"
	//--------------------------------------------------------
	function conv_fan_temp_stop($farmID, $dongID, $temp){
		return conv_remote_setting_with_temp("4F", $farmID, $dongID, $temp);
	}

	//--------------------------------------------------------
	// 원격 설정 명령
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_remote_setting($itr_comm, $farmID, $dongID){
		$ret = "";
		$itr_head = "AA815304";
		//$itr_comm = "52";		//ascii 코드 R = 0x52
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=14; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 원격 설정 명령 + 온도값
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_remote_setting_with_temp($itr_comm, $farmID, $dongID, $temp){
		$ret = "";
		$itr_head = "AA815305";
		//$itr_comm = "52";		//ascii 코드 R = 0x52
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$itr_temp = strtoupper( sprintf("%02s", dechex( (int)$temp ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm . $itr_temp;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=16; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 원격 조회명령
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function conv_remote_check($itr_comm, $farmID, $dongID){
		$ret = "";
		$itr_head = "AA816D04";
		//$itr_comm = "4D";		//ascii 코드 M = 0x4D
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=14; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// 원격 조회명령 + 저울까지
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// $cellID : 저울		입력형식 : "01"
	//--------------------------------------------------------
	function conv_remote_check_with_cell($itr_comm, $farmID, $dongID, $cellID){
		$ret = "";
		$itr_head = "AA816D05";
		//$itr_comm = "4D";		//ascii 코드 M = 0x4D
		$itr_crc = "";
		$itr_tail = "EE";

		$farmID = substr($farmID, 2, 4);
		$itr_farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$itr_dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );
		$itr_cellID = get_cell($cellID, "0");

		$ret = $itr_head . $itr_farmID . $itr_dongID . $itr_comm . $itr_cellID;
		
		$itr_crc = substr($ret, 2, 2);

		for($i=4; $i<=16; $i=$i+2){
			$itr_crc = make_crc($itr_crc, substr($ret, $i, 2));
		}
		
		$ret = $ret . $itr_crc . $itr_tail;

		return $ret;
	}

	//--------------------------------------------------------
	// crc 생성
	//--------------------------------------------------------
	function make_crc($hex_1, $hex_2){
		$x1_1 = hexdec(substr($hex_1, 0, 1));
		$x1_2 = hexdec(substr($hex_1, 1, 1));
		$x2_1 = hexdec(substr($hex_2, 0, 1));
		$x2_2 = hexdec(substr($hex_2, 1, 1));
		
		$ret = dechex($x1_1 ^ $x2_1) . dechex($x1_2 ^ $x2_2);
		$ret = strtoupper($ret);

		return $ret;
	}

	//--------------------------------------------------------
	// 저울번호 얻어오기
	//--------------------------------------------------------
	function get_cell($cellID, $append){
		$ret = (int)$cellID;
		if($ret <= 10){
			$ret = strtoupper(dechex($ret));
		}
		$ret = $append . $ret;

		return $ret;
	}

	//var_dump($_REQUEST);

	if(!empty($_REQUEST["farmID"])){
		
		$farmID = $_REQUEST["farmID"];
		$dongID = $_REQUEST["dongID"];
		$cellID = $_REQUEST["cellID"];
		$temp = $_REQUEST["temp"];

		$comm = $_REQUEST["comm"];

		if(is_numeric($farmID) && is_numeric($dongID) && is_numeric($cellID) && is_numeric($temp) && !empty($comm)){
			$farmID = "KF" . sprintf("%04s", $farmID);
			$dongID = sprintf("%02s", $dongID );
			$cellID = sprintf("%02s", $cellID );
			
			$send = "";

			switch($_REQUEST["comm"]){
				case "G/W버전":
					$send = conv_itr_ctrl_firmware_check($farmID, $dongID);
					break;
				case "저울버전":
					$send = conv_itr_cell_firmware_check($farmID, $dongID);
					break;
				case "로그삭제":
					$send = conv_itr_log_delete($farmID, $dongID);
					break;
				case "저울영점":
					$send = conv_itr_zero_set($farmID, $dongID, $cellID);
					break;
				case "재부팅":
					$send = conv_reboot($farmID, $dongID);
					break;
				case "업데이트":
					$send = conv_update_firmware($farmID, $dongID);
					break;
				case "팬설정조회" :
					$send = conv_fan_check($farmID, $dongID);
					break;
				case "팬동작온도" :
					$send = conv_fan_temp_start($farmID, $dongID, $temp);
					break;
				case "팬정지온도" :
					$send = conv_fan_temp_stop($farmID, $dongID, $temp);
					break;
				case "저울개별조회" :
					$send = conv_remote_check_with_cell("57", $farmID, $dongID, $cellID);
					break;
				case "저울환경조회" :
					$send = conv_remote_check("53", $farmID, $dongID);
					break;
			}

			//var_dump($send);

			$port = 3300;
			//$host = "192.168.0.60";
			$host = "kokofarm.co.kr";

			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("error : create fail");
			$conn = socket_connect($sock, $host, $port) or die("error : connect fail");
			
			$ret = "";
			$len = strlen($send);

			for($i=0; $i<$len; $i+=2){
				//$retstr .= "\x" . substr($comm, $i, 2);
				$ret .= pack("H*", substr($send, $i, 2));
			}
			
			try{
				socket_write($sock, $ret, $len/2) or die("error : write fail");

				$receive = socket_read($sock, 1024) or die("error : read fail");	//20-10-19 농장, 동 조회 패킷 날라오므로 회피해야함

				$receive = socket_read($sock, 1024) or die("error : read fail");
				$receive = substr($receive, 2);
				$receive = json_decode($receive);

				var_dump($receive);

				socket_close($sock);
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}
	else{
		
	}

?>

<!-- <form action="kkf_itr.php" method="post">
	<p>
		<strong>농장</strong>
		<input type="text" name="farmID" value="<? echo $_REQUEST["farmID"] ?>">
	</p>
	<p>
		<strong>동&nbsp&nbsp&nbsp</strong>
		<input type="text" name="dongID" value="<? echo $_REQUEST["dongID"] ?>">
	</p>
	<p>
		<strong>저울</strong>
		<input type="text" name="cellID" value="<? echo $_REQUEST["cellID"] ?>">
	</p>
	<p>
		<strong>온도값</strong>
		<input type="text" name="temp" value="<? echo $_REQUEST["temp"] ?>">
	</p>
	<p>
		<input type="submit" name="comm" value="G/W버전">
		<input type="submit" name="comm" value="저울버전">
		<input type="submit" name="comm" value="로그삭제">
		<input type="submit" name="comm" value="저울영점">
		<input type="submit" name="comm" value="재부팅">
		<input type="submit" name="comm" value="업데이트">
		<input type="submit" name="comm" value="팬설정조회">
		<input type="submit" name="comm" value="팬동작온도">
		<input type="submit" name="comm" value="팬정지온도">
		<input type="submit" name="comm" value="저울개별조회">
		<input type="submit" name="comm" value="저울환경조회">
	</p>
	
</form> -->