<?php
session_start();
if(isset($_SESSION['email'])){
    $db=new mysqli("localhost","root","","demo");
$email=$_SESSION['email'];
$check=$db->query("select * from users where email='$email'");
        if($check->num_rows!=0){
            $get_name=$db->query("select name from users where email='$email'");
            $name_array=$get_name->fetch_assoc();
            $name=$name_array['name'];
            $get_id=$db->query("select id from users where email='$email'");
            $id_array=$get_id->fetch_assoc();
            $id=$id_array['id'];
            $sql = "SELECT * FROM user_".$id." ORDER BY id DESC LIMIT 1";
            $get_fname=$db->query($sql);
            if($get_fname){
            
            $fname_array=$get_fname->fetch_assoc();
            if($fname_array){
                $fname=$fname_array['file_name'];
                $photo="../data/user_".$id."/".$fname;
            }
            
            }


            
         

}}
else{
header("location:../login/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../jquery.js"></script>
    <style>
        .main-container{
            width:100%;
            height:100vh;
        }
        .left{
            width:17%;
            height:100%;
            background-color:#ccc;
        }
        .right{
            width:83%;
            height:100%;
            background-color:gray;
            overflow-x: hidden;
            overflow-y:auto;
        
        }
        .left div .profile_pic img{
            width:100px;
            height:100px;
            border-radius:50%;
            border:2px solid white;
        }


input[type="file"] {
  display: none;
}

.custom-file-upload {
  display: inline-block;
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
  font-family: sans-serif;
}

.custom-file-upload:hover {
  background-color: #45a049;
}
.thumb{
    width :50%;
}
.content {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap; 
  justify-content: flex-start;
  padding:20px;
  border:0px solid;

}

    </style>
</head>
<body>
    <div class="main-container d-flex">
        <div class="left">
        <div class="d-flex justify-content-center align-items-center flex-column pt-5">
            <div class="profile_pic d-flex justify-content-center align-items-center">
            <img src="<?php echo $photo;?>" width="100%"  alt="Please Upload your Photo"></i>
           
        </div>
    <span class="text-white"><?php echo $name; ?></span>
 <form action="./uploadfile.php" method="POST" enctype="multipart/form-data">
  <label for="fileInput" class="custom-file-upload">
    Upload Image
  </label>
  <input type="file" id="fileInput" name="photo" accept="image/*" required>
  <input type="submit" value="Save" style="padding:10px;">
</form>
<form action="../editname/edit.php">
<button class="custom-file-upload" style="margin:10px 0px;">Edit Name</button></form>

<div  class="line">

<?php
$get_data=$db->query("select * from users where email='$email'");
$data_array=$get_data->fetch_assoc();
$storage=$data_array['storage'];
$usage_storage=$data_array['used_storage'];

?>
<div style="margin-bottom:10px;">
<label class="text-white">Storage:</label>
    <span  style="color:red;padding:10px;"><?php echo "Total:".$storage."MB/ Used:".$usage_storage."MB";?></span>
</div>
</div>
<form action="./drop.php">
<button class="custom-file-upload mb-4">Delete whole Data</button></form>

<form action="../logout/logout.php">
<button class="custom-file-upload">Logout</button></form>
</div>
    
        </div>
        <div class="right">
            <nav class="navbar navbar-light bg-light sticky-top">
           
            <div class="container-fluid">
                <h2>Image gallery</h2>
            <form class="d-flex p-3 ml-auto">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="type">
            <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            </div>
            </nav>

            <div class="content">
                
                <?php 
                $tname="user_".$id;
                $query="select * from $tname";
                $file_res=$db->query($query);
                while($file_array=$file_res->fetch_assoc()){
                    $fd_array=pathinfo($file_array['file_name']);
                    $file_name=$fd_array['filename'];
                    $f_ext=$fd_array['extension'];
                    $basename=$fd_array['basename'];

                    echo '
                    <div class="col-md-4">
                    <div>
                    <div style="text-align:center;">';
                    
                    $photo="../data/user_".$id."/".$file_name.".".$f_ext;
            
                    if($f_ext){
                        echo "<img src='$photo' class='thumb'>";
                    }
                    echo '</div>
                    <div>
                    <p  align="center">'.$file_name.'</p>
                    <hr>
                    <div class="d-flex justify-content-around">
                    <a href="../data/user_'.$id.'/'.$basename.'" target="blank"><i class="fas fa-eye"></i></a>
                    <a href="../data/user_'.$id.'/'.$basename.'" download><i class="fas fa-download"></i></a>
                  <i style="cursor:pointer;" class="fas fa-trash delete" id="'.$file_array['id'].'" folder="'.$tname.'" file="'.$basename.'" ></i>

                    </div>
                    </div>
                    </div>
                    </div>
                    
                    ';


                }

                ?>
            </div>
        
  </div>
</body>
<script>
    $(document).ready(function(){
        $(".delete").each(function(){
            $(this).click(function(){
                var id=$(this).attr('id');
                var file=$(this).attr('file');
                var folder=$(this).attr('folder');
            
                $.ajax(
                    {
                        type:"POST",
                        url:"../delete/delete.php",
                        data:{
                            id:id,
                            folder:folder,
                            file:file
                        },
                        success:function(response){
                            alert(response);
                            location.reload();
                        }

                    }
                )
            })
        })
    })
    
</script>
</html>