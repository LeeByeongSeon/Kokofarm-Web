<?


class mongo_conn{

    // 멤버 선언부
    private $mongo_manager = null;

    // ********** 싱글턴 구조 시작
    private static $inst = null;

    public static function get_inst(){

        if(self::$inst === null){
            self::$inst = new static();
        }

        self::$inst->db_init();

        return self::$inst;
    }

    // 생성 제한
    private function __construct(){
        //echo "__construct <br>";
    }

    public function __destruct(){
        if($this->mongo_manager != null){
            //$this->mongo_manager->close();
        }
        //echo "__destruct <br>";
    }

    // 복제 제한
    public function __clone(){
        //echo "__clone <br>";
    }

    // 해제 제한
    public function __wakeup(){
        //echo "__wakeup <br>";
    }

    // ********** 싱글턴 구조 종료

    // db setting
    private function db_init(){

        if($this->mongo_manager === null){    // 아직 연결이 안된 경우에만 작업함
            $config_arr = $this->get_config();
            $mongo_host	= $config_arr["mongo_host"]; 
            $mongo_user	= $config_arr["mongo_user"];
            $mongo_pass	= $config_arr["mongo_pass"];
            $mongo_name	= $config_arr["mongo_name"];

            //var_dump("mongodb://" .$mongo_user. ":" .$mongo_pass. "@" .$mongo_host. "/" .$mongo_name);

            // 실제 db 연결
           // $this->mongo_manager = new MongoDB\Driver\Manager("mongodb://" .$mongo_user. ":" .$mongo_pass. "@127.0.0.1:27017/" .$mongo_name);
            $this->mongo_manager = new MongoDB\Driver\Manager("mongodb://" .$mongo_user. ":" .$mongo_pass. "@" .$mongo_host. "/" .$mongo_name);
        }
    }

    // config read
    private function get_config(){
        $config_arr = array();

        $fp = fopen("../common/php_module/mongo_info.cfg", "r");
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mongo_host"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mongo_user"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mongo_pass"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mongo_name"] = trim(substr($tmp,0,$posi));
        fclose($fp);

        return $config_arr;
    }

	// aggregate 파이프라인을 받아 결과값을 리턴
	public function aggregate($database, $collection, $pipeline){
		$comm = new MongoDB\Driver\Command([
			"aggregate" 	=> $collection,
			"pipeline"		=> $pipeline,
			"cursor"		=> ["batchSize" => 1001]
		]);

		$cursor = $this->mongo_manager->executeCommand($database, $comm);

		$ret = array();
		foreach($cursor as $document){
			$ret[] = $document;
		}

		return $ret;
	}
}

// 인서트 예제
// $bulk = new MongoDB\Driver\BulkWrite();
// $bulk->insert(["_id" => 1, "x" => 1]);
// $bulk->insert(["_id" => 2, "x" => 2]);

// $this->mongo_manager->executeBulkWrite("kokofarm4.test", $bulk);


?>