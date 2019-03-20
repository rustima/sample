<?php
/*
 * 用于测试的轻量级PDO
 * 密码采用crypt保存在数据库中
 * 
 * @author rustima
 * @version 0.6
 * 
 */

class myPDO{
    private $hostname = "";
    private $user = "";
    private $pwd = "";
    private $db = "";
    private $conn = "";
    
    /*
     * @构造函数
     * @param string $hostname
     * @param string $user
     * @param string $pwd
     * @param string $db
     * 
     */
    final public function __construct($hostname = "localhost",$user = "root",$pwd = "123456",$db = "test"){
        $this->hostname = $hostname;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->db = $db;
    }
    
    /*
     * @打开数据库连接
     * @return mixed 成功返回连接对象，否则返回FALSE
     * 
     */
    public function conn(){
        if($this->hostname&&$this->user&&$this->pwd&&$this->db){
            $this->conn = mysqli_connect($this->hostname,$this->user,$this->pwd,$this->db);
            //             echo "111";
            $this->conn->query("SET NAMES UTF8");  //设置编码utf8
            var_dump($this->conn);
            if(!mysqli_connect_errno()){
            return $this->conn;
            }else{
                echo "conn error";
                return FALSE;
            }
        }else{
            echo "setting error:";
            return FALSE;
        }
        //         echo "some";
    }
    
    /*
     * @添加用户
     * 
     * @param string $userid
     * @param string $userpwd
     * @param string $username
     * @param string $detail
     * @return boolean 成功返回TRUE，否则错误信息和返回FALSE
     */
    public function addmember($userid,$username,$userpwd,$detail){
        $userpwd = $this->mycrypt($userpwd);
        $this->conn->query("INSERT INTO `member` (`id`, `name`, `pwd`, `detail`) VALUES ('$userid', '$username', '$userpwd', '$detail')");
        if($this->conn->error){
            echo "MYSQL添加字段时错误: ".$this->conn->error;
            return FALSE;
        }else
        return TRUE;
    }
    
    public function alter(){}
    
    /*
     * @删除指定用户
     * @param string @userid
     * @return boolean 成功返回TRUE，否则错误信息和返回FALSE
     * 
     */
    
    public function delete($userid){
        $this->conn->query("DELETE FROM member WHERE member.id = '$userid'");
        if($this->conn->error){
            echo "MYSQL删除字段时错误:".$this->conn->error;
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    /*
     * @返回指定id的密码
     * @param string $id 获取id
     * @return string 返回密码
     * 
     */
//     public function select($id){
//         $query = "select pwd from member where id = '$id'";
//         if(@$result = $this->conn->query($query)){
// //             var_dump($result);
//             $arr=$result->fetch_array(MYSQLI_ASSOC);
//             }
//             return $arr['pwd'];
//     }
    
    /*
     * @用户密码验证
     * @param string $userid 待验证的ID
     * @param string $pwd 待验证的密码
     * @return boolean 密码正确返回TRUE，否则返回FALSE
     * 
     */
    public function verify($userid,$userpwd){
//         $pwd = $userpwd;
        $p = $this->conn->query("select pwd from member where id ='$userid'"); //获取密码
//         $c_pwd = $this->mycrypt($userpwd);
        if(password_verify($userpwd, $p)){
            return TRUE;
        }else return FALSE;
    }
    
    /*
     * @执行语句
     * @param string $query 
     * @return mixed 成功返回结果集数组，否则返回FALSE
     * 
     */
    private function query($query){
        
        if(@$result = $this->conn->query($query)){
            //             return $result;
            
            foreach($result as $result){
                $arr[] = $result;
            }
            return $arr;
        }else 
        {
            echo "query error";
            return FALSE;
        }
        
    }
    
//     public function fetch($result){
//         foreach($result as $result){
//             $arr[] = $result;
//         }
//         return $arr;
//     }

    /*
     * @加密函数
     * 
     * @param string $pwd 
     * @return mixed 成功返回加密后的密码，否则FALSE
     * 
     */
    private function mycrypt($pwd){
        if($pwd){
        $pwd = sha1($pwd);
        $salt = substr($pwd,1,3);
        return crypt($pwd,$salt);
        }else return FALSE;
    }
    
    public function close(){
        mysqli_close($this->conn);
    }
    
}