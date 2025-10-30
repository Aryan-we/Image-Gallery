<?php
session_start();
$email=$_SESSION['email'];
$db = new mysqli("localhost", "root", "", "demo");
$id = $_POST['id'];
$file = $_POST['file'];
$folder = $_POST['folder'];
$del = unlink("../data/".$folder."/".$file);

if ($del) {
    $del_sql=$db->query("DELETE FROM $folder WHERE id='$id'");
    if ($del_sql) {
        $used_result = $db->query("SELECT SUM(file_size) AS used FROM `$folder`");
                        $row = $used_result->fetch_assoc();
                        $new_used_storage = (float)$row['used'];
                        $update_query = "UPDATE users SET used_storage='$new_used_storage' WHERE email='$email'";
                        if($db->query($update_query)){

                            echo "Photo Deleted";
                        }else{
                            echo "storage not updated";
                        }

                       // header("Location: ./profile.php");

    } else {
        echo "Failed";
    }
}else{
    echo "file not deleted";
}
?>
