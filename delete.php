<?php 
require 'dbConnection.php';
  
$id = $_GET['id'];

# Check if Id ex ... 
 $sql = "select * from users where id = $id ";
 $data = mysqli_query($con,$sql);

  if( mysqli_num_rows($data) == 1){
     
    # delete op 
     $sql = "delete from users where id = $id";
     $op  = mysqli_query($con,$sql);
     if($op){
        $Message =  "Raw Deleted";
     }else{
        $Message =  'Error try Again';
     }


  }else{
       $Message =  "Invalid Id ";
  }


   $_SESSION['Message'] = $Message;

   header("location: index.php");


?>