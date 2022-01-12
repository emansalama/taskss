<?php

require 'dbConnection.php';

$id = $_GET['id'];

# Check if Id ex ...
$sql = "select * from users where id = $id ";
$data = mysqli_query($con, $sql);
#if id exist
if (mysqli_num_rows($data) == 1) {
    # fetch data
    $Userdata = mysqli_fetch_assoc($data);
} else {
    $Message = 'Invalid Id ';
    $_SESSION['Message'] = $Message;
    header('Location: index.php');
}

 function Clean($input){

    return  trim(strip_tags(stripslashes($input)));
  }

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title = Clean($_POST['title']);
    $content = Clean($_POST['content']);
    $date = $_POST['date'];


 $errors = [];

  # Validate title ... 
  if(empty($title)){
    $errors['Name'] = "Field Required";
}


  # Validate content 
  if(empty($content)){
      $errors['content'] = "Field Required";
  }elseif(strlen($content) < 5){
    $errors['content'] = "Length must be >= 50 chars";
  }

    # Validate date
    if (empty($date)) {
        $errors['date'] = 'Field Required';
    }
     //upload image
     if(!empty($_FILES['image']['name'])){

        $imgName     = $_FILES['image']['name'];
        $imgTempPath = $_FILES['image']['tmp_name'];
        $imagSize    = $_FILES['image']['size'];
        $imgType     = $_FILES['image']['type'];
     
     
         $imgExtensionDetails = explode('.',$imgName);
         $imgExtension        = strtolower(end($imgExtensionDetails));
     
         $allowedExtensions   = ['png','jpg','gif'];
     
            if(in_array($imgExtension ,$allowedExtensions)){
                // upload code ..... 
               
             $finalName = rand().time().'.'.$imgExtension;
     
              $disPath = './uploads/'.$finalName;
               
             if(move_uploaded_file($imgTempPath,$disPath)){
                 echo 'Image Uploaded';
             }else{
                 echo 'Error Try Again';
             }
     
            }else{
                echo 'Extension Not Allowed';
            }
     
     
        }
        else{
            echo 'Image Field Required';
        }




 if(count($errors) > 0){
     foreach ($errors as $key => $value) {
         # code...
         echo '* '.$key.' : '.$value.'<br>';
     }
 }else{

    $sql = "update users set title='$title' , content = '$content', date='$date' where id  = $id"; 

    $op  = mysqli_query($con,$sql);

    if($op){
        $Message = "Raw Updated";
    }else{
        $Message = "Error Try Again ".mysqli_error($con) ;
    }

    $_SESSION['Message'] = $Message;
    header("Location: index.php");

}

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Update</h2>


        <form action="edit.php?id=<?php echo $Userdata['id']; ?>" method="post">

            
            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" id="exampleInputName" name="title" value="<?php echo $Userdata['title']; ?>"
                    aria-describedby="" placeholder="Enter title">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="content"
                    value="<?php echo $Userdata['content']; ?>" aria-describedby="emailHelp" placeholder="Enter content">
            </div>
            <div class="form-group">
            <label for="exampleInputEmail">Date</label>
                <input type="date" class="form-control" id="exampleInputEmail1" name="date"
                    value="<?php echo $Userdata['date']; ?>" aria-describedby="emailHelp" placeholder="Enter content">
            </div>
            <div class="form-group">
            <label for="exampleInputEmail">image</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name="image"
                    value="<?php echo $Userdata['image']; ?>" aria-describedby="emailHelp" placeholder="Enter content">
            </div>




            <button type="submit" class="btn btn-primary">Edit</button>
        </form>



</body>

</html>
