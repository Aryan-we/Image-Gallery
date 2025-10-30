<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGNUP AND LOGIN FORM</title>
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
    
    <div class="login">
        <h1>Login</h1>
        <form action="login.php" method="POST">
        <input type="email" placeholder="Email" name="email" required><br>
        <input type="password" placeholder="Password" name="password" required><br>
        <input type="submit">
    </div>
    </div>
</body>
</html>