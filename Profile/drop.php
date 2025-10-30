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
            $sql = "truncate table user_".$id."";
            $sql1="update users set used_storage='0' where id='$id'";
            $qry1=$db->query($sql);
            $qry2=$db->query($sql1);
            function deleteDirectory($dir) {
            if (!file_exists($dir)) return true;
            if (!is_dir($dir)) return unlink($dir);

            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') continue;        
                deleteDirectory($dir . DIRECTORY_SEPARATOR . $item);
         }
            return rmdir($dir);
        }

            deleteDirectory("../data/user_$id");
            header("location:./profile.php");
    


            
         

}}
?>