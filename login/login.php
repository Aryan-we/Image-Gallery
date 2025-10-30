<?php
session_start();
$db=new mysqli("localhost","root","","demo");
if($db->connect_error){
    echo "Connection Failed";
}else{
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $password=$_POST['password'];
        $email=$_POST['email'];
        $check=$db->query("select * from users where email='$email' and password='$password'");
        if($check->num_rows!=0){
            echo "login Success";
            $_SESSION['email']=$email;
            header("location:../Profile/profile.php");
        }else{
           echo "Login Failed";
           echo "<body><br><a href='./signup and login form.php'><button style='padding:10px;margin-top:10px;'>Login again</button></a></body>";
            
        }

    }else{
        header("location:./login form.php");
    }
}
?>