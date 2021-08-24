<?


class sql_conn{

    // 멤버 선언부
    private $local_db_conn = null;

    // ********** 싱글턴 구조 시작
    private static $inst = null;

    public static function get_inst(){

        if(self::$inst === null){
            self::$inst = new static();
        }

        self::$inst->db_init();

        //echo "call get_inst <br>";

        return self::$inst;
    }

    // 생성 제한
    private function __construct(){
        //echo "__construct <br>";
    }

    public function __destruct(){
        if($this->local_db_conn != null){
            //var_dump($this->local_db_conn);
            $this->local_db_conn->close();
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

        if($this->local_db_conn === null){    // 아직 연결이 안된 경우에만 작업함
            $config_arr = $this->get_config();
            $mysql_host	= $config_arr["mysql_host"]; 
            $mysql_user	= $config_arr["mysql_user"];
            $mysql_pass	= $config_arr["mysql_pass"];
            $mysql_name	= $config_arr["mysql_name"];

            // 실제 db 연결
            $this->local_db_conn = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_name, 3306);
            
            if($this->local_db_conn->connect_error){
                echo "Connection failed : " . $this->local_db_conn->connect_error;
            }

            $this->local_db_conn->set_charset("utf8");
            //echo "db_init <br>";
        }
    }

    // config read
    private function get_config(){
        $config_arr = array();

        $fp = fopen("../common/php_module/mysql_info.cfg", "r");
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mysql_host"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mysql_user"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mysql_pass"] = trim(substr($tmp,0,$posi));
        $tmp = fgets($fp); $posi = strpos($tmp,";"); $config_arr["mysql_name"] = trim(substr($tmp,0,$posi));
        fclose($fp);

        return $config_arr;
    }

    public function get_select_count($count_sql){
        $result = $this->local_db_conn->query($count_sql);

        return $result->num_rows;
    }

    // select
    public function select($select_sql){
        $data_arr = array();
        $rec_no = -1;

        $result = $this->local_db_conn->query($select_sql);
        
        if($result != null && $result->num_rows > 0){

            // field 이름 및 타입 가져오기
            $field_info = $result->fetch_fields();

            while($row = $result->fetch_array()){
                $rec_no++;
                
                foreach($field_info as $field){
                    $val = $row[$field->name];
                    if(empty($val)){
                        $data_arr[$rec_no][$field->name] = 0;
                        // 자료형에 따라 디폴트 값 분기
                        // 252  : blob
                        // 253  : varchar 
                        // 7    : timestamp 
                        // 12   : datetime
                        if($field->type == 252 || $field->type == 253 || $field->type == 7 || $field->type == 12){
                            $data_arr[$rec_no][$field->name] = "";
                        }
                    }
                    else{
                        $data_arr[$rec_no][$field->name] = $row[$field->name];
                    }
                }
            }
        }
        return $data_arr;
    }

    // public function excuteQuery($query_type, $table_name, $data_arr, $where_str){

    //     $excute_sql = "";

    //     switch($query_type){
    //         case "INSERT":
    //             $temp_left  = ""; 
    //             $temp_right = "";

    //             foreach($data_arr as $key => $val){ 
    //                 if(strlen($val) > 0){  
    //                     $temp_left  .= $key . ", ";
    //                     $temp_right .= "\"$val\", ";
    //                 } 
    //             }

    //             $excute_sql = "INSERT INTO " . $table_name . "(" . substr($temp_left, 0, -2) . ") VALUES(" . substr($temp_right, 0, -2) . ");";
    //             break;

    //         case "UPDATE":
    //             $temp = "";
    //             foreach($data_arr as $key => $val){ 
    //                 if ($val=="NULL"){
    //                     $temp .= $key . " = $val, "; 
    //                 }
    //                 else{
    //                     $temp .= $key . "= \"$val\", "; 
    //                 }
                    
    //             }
    //             $excute_sql = "UPDATE " . $table_name . " SET " . substr($temp, 0, -2) . " WHERE " . $where_str . ";";
    //             break;

    //         case "DELETE":
    //             $excute_sql = "DELETE FROM " . $table_name . " WHERE " . $where_str . ";";
    //             break;
    //     }
        
    //     // 실제 쿼리 적용
    //     $this->local_db_conn->query($excute_sql);
    // }

    // insert 메소드
    public function insert($table_name, $data_arr){
        $temp_left  = ""; 
        $temp_right = "";

        foreach($data_arr as $key => $val){ 
            if(strlen($val) > 0){  
                $temp_left  .= $key . ", ";
                $temp_right .= "\"$val\", ";
            } 
        }

        $excute_sql = "INSERT INTO " . $table_name . "(" . substr($temp_left, 0, -2) . ") VALUES(" . substr($temp_right, 0, -2) . ");";
        $this->local_db_conn->query($excute_sql);
    }

    // update 메소드
    public function update($table_name, $data_arr, $where_str){
        $temp = "";

        foreach($data_arr as $key => $val){ 
            if ($val=="NULL"){
                $temp .= $key . " = $val, "; 
            }
            else{
                $temp .= $key . "= \"$val\", "; 
            }
            
        }

        $excute_sql = "UPDATE " . $table_name . " SET " . substr($temp, 0, -2) . " WHERE " . $where_str . ";";
        $this->local_db_conn->query($excute_sql);
    }

    // delete 메소드
    public function delete($table_name, $where_str){

        $excute_sql = "DELETE FROM " . $table_name . " WHERE " . $where_str . ";";

        $this->local_db_conn->query($excute_sql);
    }

    public function check_str($chk_str){
        $this->db_init();

        $ret = trim($chk_str);
        $ret = $this->local_db_conn->real_escape_string($chk_str); //SQL injection 공격 방지
        $ret = str_replace("," , "", $chk_str);
        
        return $ret;
    }

}



?>