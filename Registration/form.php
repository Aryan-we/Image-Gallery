<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <script src="../jquery.js"></script>
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        input{
            margin:10px 0px;
            padding:10px;
            width: 80%;
        }
        .container{
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:space-around;
            width:100%;
            border:2px solid;
            background:

        }
        .container .register input[type='submit']{
            width:90%;
            cursor: pointer;


        }
        input[type='button']{
            width:90%;
            cursor: pointer;
            border:none;


        }
        .pass{
            position: relative;
        }
        i{
            position: absolute;
            top:20px;
            right:40px;
            cursor: pointer;
            color:#ccc;
        }
    

    </style>
</head>
<body>
    <div class="container">
    <div class="register">
       
        <h1 align="center">Register</h1>
        <form action="#" method="POST">
        <input type="text" placeholder="Enter name" name="name" required><br>
        <input type="email" placeholder="Email" name="email" required><br>
       <div class="pass"><input type="text" minlength="8" placeholder="Password" name="password" required id="password"><br>
        <i class="fa fa-eye" id="icon"></i></div> 
        <input type="submit" value="Generate Password" class="generate">
        <input type="submit">
        <a href="../login/login form.php"><input type="button" value="Login Here" class="login"></a>
    </div></form>
    </div>
</body>
<script>
    $(document).ready(function(){
        $(".generate").click(function(e){
           e.preventDefault();
            $.ajax({
                type:"POST",
                url:"./check.php",
                success:function(response){
                    $("#password").val(response.trim());
                }
            });

        });
        $("#icon").click(function(){
            if($("#password").attr("type")=="password"){
                $("#password").attr("type","text");
                $(this).css({color:"black"});
            }else{
                $("#password").attr("type","password");
                $(this).css({color:"#ccc"});

            }

        })
    });

    </script>
</html>
<?php
$db=new mysqli("localhost","root","","demo");
if($db->connect_error){
    echo "Connection Failed";
}else{
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $name=$_POST['name'];
        $password=$_POST['password'];
        $email=$_POST['email'];
        $p="free";
        $s=10;
        $su=0;
        $response=$db->query("select email from users where email='$email'");
        if($response->num_rows==1){
            echo "<script>alert('User Already exist!')</script>";
                
            
        }else{
            $store="insert into users(name,password,email,plans,storage,used_storage) values('$name','$password','$email','$p','$s','$su')";
            if($db->query($store)){
        
                echo "<script>alert('Register successfully')</script>";
                //header("location: form.php");
            
            
           
            
            }else{
                echo "<script>alert('Failed to Register')</script>";
            }}

    }
}
?>