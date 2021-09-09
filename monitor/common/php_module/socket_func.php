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

	const HOST = "kokofarm.co.kr";
    const PORT = 3300;

    //--------------------------------------------------------
	// 패킷 생성
	// $comm : 명령 바이트 (1 Byte)
	// $data : data 바이트 (n Byte)
	//--------------------------------------------------------
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
	// 저울 원격 설정 명령 (0x54)
	// $sub : 서브명령
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	// $cellID : 저울		입력형식 : "01"
	//--------------------------------------------------------
	function comm_remote_set_cell($sub, $farmID, $dongID, $cellID, $value = ""){
		$ret = "";

		$farmID = substr($farmID, 2, 4);
		$farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );
		$cellID = get_ascii_number($cellID[1]);		// 원퍼스트 펌웨어 최대갯수가 10개이고, 아스키로 처리됨

		$data = $farmID . $dongID . $sub . $cellID . get_ascii_number($value);
		$ret = make_packet("54", $data);

		return $ret;
	}

	//--------------------------------------------------------
	// GW 원격 설정 명령 (0x53)
	// $sub : 서브명령
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function comm_remote_set_gw($sub, $farmID, $dongID, $value = ""){
		$ret = "";

		$farmID = substr($farmID, 2, 4);
		$farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$data = $farmID . $dongID . $sub;
		if($value != ""){
			$data .= strtoupper( sprintf("%02s", dechex( (int)$value ) ) );
		}

		$ret = make_packet("53", $data);

		return $ret;
	}

	//--------------------------------------------------------
	// GW 원격 조회 명령 (0x6D)
	// $sub : 서브명령
	// $farmID : 농장		입력형식 : "KF0001"
	// $dongID : 동			입력형식 : "01"
	//--------------------------------------------------------
	function comm_remote_info_gw($sub, $farmID, $dongID, $cellID = ""){
		$ret = "";

		$farmID = substr($farmID, 2, 4);
		$farmID = strtoupper( sprintf("%04s", dechex( (int)$farmID ) ) );
		$dongID = strtoupper( sprintf("%02s", dechex( (int)$dongID ) ) );

		$cellID = $cellID != "" ? get_ascii_number($cellID[1]) : "";

		$data = $farmID . $dongID . $sub . $cellID;
		$ret = make_packet("6D", $data);

		return $ret;
	}

	// 실제 사용할 명령 변환 함수 모음 ---------------------------------------------------------
	// param
	// $sub : 서브명령
	// $farmID : 농장			입력형식 : "KF0001"
	// $dongID : 동				입력형식 : "01"
	// $cellID : 저울번호		입력형식 : "01" 
	// $value : 온도 및 기타 설정값 입력
	//--------------------------------------------------------

	/* 저울 설정 명령*/
	//--------------------------------------------------------
	// 영점 설정 
	//--------------------------------------------------------
    function cell_zero_set($farmID, $dongID, $cellID){
		return comm_remote_set_cell("46", $farmID, $dongID, $cellID);		// 0x46 (F)
	}

	//--------------------------------------------------------
	// 500점 설정
	//--------------------------------------------------------
	function cell_500_set($farmID, $dongID, $cellID){
		return comm_remote_set_cell("47", $farmID, $dongID, $cellID, "500");		// 0x47 (G)
	}

	//--------------------------------------------------------
	// 온도 보정값 설정
	//--------------------------------------------------------
	function cell_temp_set($farmID, $dongID, $cellID, $value){
		return comm_remote_set_cell("54", $farmID, $dongID, $cellID, $value);		// 0x54 (T)
	}

	//--------------------------------------------------------
	// 습도 보정값 설정
	//--------------------------------------------------------
	function cell_humi_set($farmID, $dongID, $cellID, $value){
		return comm_remote_set_cell("48", $farmID, $dongID, $cellID, $value);		// 0x48 (H)
	}

	//--------------------------------------------------------
	// 이산화탄소 보정값 설정
	//--------------------------------------------------------
	function cell_co2_set($farmID, $dongID, $cellID, $value){
		return comm_remote_set_cell("50", $farmID, $dongID, $cellID, $value);		// 0x50 (P)
	}

	//--------------------------------------------------------
	// 암모니아 보정값 설정
	//--------------------------------------------------------
	function cell_nh3_set($farmID, $dongID, $cellID, $value){
		return comm_remote_set_cell("4D", $farmID, $dongID, $cellID, $value);		// 0x4D (M)
	}


	/* GW 설정 명령*/
	//--------------------------------------------------------
	// 로그데이터 삭제
	//--------------------------------------------------------
    function gw_log_delete($farmID, $dongID){
		return comm_remote_set_gw("53", $farmID, $dongID);		// 0x53 (S)
	}

	//--------------------------------------------------------
	// 업데이트 시작
	//--------------------------------------------------------
    function gw_update($farmID, $dongID){
		return comm_remote_set_gw("57", $farmID, $dongID);		// 0x57 (W)
	}

	//--------------------------------------------------------
	// 재부팅
	//--------------------------------------------------------
    function gw_restart($farmID, $dongID){
		return comm_remote_set_gw("52", $farmID, $dongID);		// 0x52 (R)
	}

	//--------------------------------------------------------
	// 팬 동작온도 설정
	//--------------------------------------------------------
    function gw_fan_on_temp($farmID, $dongID, $value){
		return comm_remote_set_gw("54", $farmID, $dongID, $value);		// 0x54 (T)
	}

	//--------------------------------------------------------
	// 팬 정지온도 설정
	//--------------------------------------------------------
    function gw_fan_off_temp($farmID, $dongID, $value){
		return comm_remote_set_gw("4F", $farmID, $dongID, $value);		// 0x4F (O)
	}


	/* GW 조회 명령*/
	//--------------------------------------------------------
	// GW 버전 조회
	//--------------------------------------------------------
    function gw_version_info($farmID, $dongID){
		return comm_remote_info_gw("56", $farmID, $dongID);		// 0x56 (V)
	}

	//--------------------------------------------------------
	// IoT저울 버전 조회
	//--------------------------------------------------------
    function cell_version_info($farmID, $dongID, $cellID){
		return comm_remote_info_gw("4D", $farmID, $dongID, $cellID);		// 0x4D (M)
	}

	//--------------------------------------------------------
	// 저울 중량 데이터 조회
	//--------------------------------------------------------
    function cell_weight_info($farmID, $dongID, $cellID){
		return comm_remote_info_gw("57", $farmID, $dongID, $cellID);		// 0x57 (W)
	}

	//--------------------------------------------------------
	// 저울 센서 데이터 조회
	//--------------------------------------------------------
    function cell_sensor_info($farmID, $dongID, $cellID){
		return comm_remote_info_gw("53", $farmID, $dongID, $cellID);		// 0x53 (S)
	}

	//--------------------------------------------------------
	// 팬 정보 조회
	//--------------------------------------------------------
    function gw_fan_info($farmID, $dongID){
		return comm_remote_info_gw("4F", $farmID, $dongID);		// 0x4F (O)
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
	// 숫자를 아스키로 변환
	//--------------------------------------------------------
	function get_ascii_number($value){
		$ascii = "";
		for($i=0; $i<strlen($value); $i++){
			$ascii .= "3" . $value[$i];
		}

		return $ascii;
	}


	// 실제 웹소켓 전송 부
	function send_packet($send){
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("error : create fail");
		$conn = socket_connect($sock, HOST, PORT) or die("error : connect fail");

		socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 4, 'usec' => 0));

		$ret = "";
		$len = strlen($send);

		for($i=0; $i<$len; $i+=2){
			$ret .= pack("H*", substr($send, $i, 2));
		}

		try{
			socket_write($sock, $ret, $len/2) or die("error : write fail");

			$receive = socket_read($sock, 1024) or die("error : read fail");	//20-10-19 농장, 동 조회 패킷 날라오므로 회피해야함

			$receive = socket_read($sock, 1024) or die("error : read fail");
			$receive = substr($receive, 2);
			$receive = json_decode($receive);

			socket_close($sock);
		}
		catch(Exception $e){
			$receive = $e->getMessage();
		}

		return $receive;

	}

?>