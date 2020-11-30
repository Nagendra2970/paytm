<?php 


class Student{
   private $servername = "localhost";
   private $username = "root";
   private $password = "";
   private $dbname = "pdodbtraining";
   private $pdoConn = '';
   public $cMemberId;
   public $cName;
   public $cEmail;
   public $cAddress;
   public $cDateOfBrith;
    public function __construct() {
        $this->pdoConn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        
    }


    function Add($cMemberId,$cName,$cEmail,$cAddress,$cDateOfBrith){
        $cStmt = '';
        $cStmt = $this->pdoConn->prepare("INSERT INTO pdocust (`id`, `name`, `email`,`address`,`dob`) VALUES (:id, :name, :email,:address,:dob)");
        $cStmt->bindParam(':id', $cMemberId);
        $cStmt->bindParam(':name', $cName);
        $cStmt->bindParam(':email', $cEmail);
        $cStmt->bindParam(':address', $cAddress);
        $cStmt->bindParam(':dob', $cDateOfBrith);

        $cStmt->execute(); 

    }


    function Update($cMemberId,$cName,$cEmail,$cAddress,$cDateOfBrith,$cPreviousId){
        $sql ='UPDATE `pdocust` SET `id`="'.$cMemberId.'",`name`="'.$cName.'",`email`="'.$cEmail.'",`address`="'.$cAddress.'",`dob`="'.$cDateOfBrith.'" WHERE id="'.$cPreviousId.'"';
        $this->pdoConn->exec($sql);        
    }

    function del(){
        // $id_d= $_POST['txtId'];
        $sql = 'DELETE FROM pdocust WHERE id='.$_POST['txtId'];
        // echo $sql;
        $this->pdoConn->exec($sql);
    }
    function search($id){ 
        $sql = 'SELECT `id`, `name`, `email`, `address`, `dob`from pdocust WHERE id='.$id;
        $res = $this->pdoConn->query($sql);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $data = $res->fetch();
      
// print_r($data );
        // $student_arr = array();
        if(isset($data) && !empty($data)){
            $this->cMemberId = $data['id'];
            $this->cName =  $data['name'];
            $this->cEmail =   $data['email'];
            $this->cAddress =   $data['address'];
            $this->cDateOfBrith =   $data['dob'];
            $this->cinputSearch  = $id;
        }else{
            echo "Student with Id : ".$id." not exists in the records";
            $this->cinputSearch = '';
        }


      
    }
    

    function GetAllStudents(){
         $data = '';
        $this->pdoConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Fetching previous Data
        $sql = 'SELECT `id`, `name`, `email`, `address`, `dob` from pdocust';
        $result = $this->pdoConn->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $student_data = array();
        while ($r = $result->fetch()){


            array_push($student_data,
                                array(
                                "id"=>$r['id'],
                                "name"=>$r['name'],
                                "email"=>$r['email'],
                                "address"=>$r['address'],
                                "dob"=>$r['dob']
                                ));
        }
         return json_encode($student_data);  
    }

}    


?>


