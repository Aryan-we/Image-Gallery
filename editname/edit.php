<?php
session_start();
$email=$_SESSION['email'];
$db=new mysqli("localhost","root","","demo");
if($db->connect_error){
    echo "Connection Failed";
}else{
if($_SERVER['REQUEST_METHOD']=="POST"){
$name=$_POST['name'];
$query="update users set name='$name' where email='$email'";
$db->query($query);
header("location:../profile/profile.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <style>
        input{
            margin:10px 0px;
            padding:10px;
        }
        .container{
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:space-around;
            width:100%;
            border:2px solid;

        }
    </style>
</head>
<body>
     <div class="container">
    
    <div class="Edit Name">
        <h1>Edit Name</h1>
        <form action="#" method="POST">
        <input type="New Name" placeholder="Name" name="name" required><br>
  
        <input type="submit" value="Save">
    </div>
    </div>
</body>
</html>