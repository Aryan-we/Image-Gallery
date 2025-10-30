<?php
session_start();

$db = new mysqli("localhost", "root", "", "demo");
if ($db->connect_error) {
    die("Connection Failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_SESSION['email'])) {
        die("Session expired. Please log in again.");
    }

    $email = $_SESSION['email'];
    $check = $db->query("SELECT * FROM users WHERE email='$email'");

    if ($check && $check->num_rows > 0) {

        $id_array = $check->fetch_assoc();
        $user_table_name = "user_" . $id_array['id'];

        // ✅ Create user-specific table if not exists
        $db->query("CREATE TABLE IF NOT EXISTS `$user_table_name` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            file_name VARCHAR(255),
            file_size FLOAT,
            upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        if (!is_dir("../data/" . $user_table_name)) {
            mkdir("../data/" . $user_table_name, 0777, true);
        }

        if (isset($_FILES['photo'])) {
            $file = $_FILES['photo'];
            $filename = basename($file['name']);
            $location = $file['tmp_name'];
            $file_size = round($file['size'] / 1024 / 1024, 2); // in MB
            $target_path = "../data/" . $user_table_name . "/" . $filename;

            if (file_exists($target_path)) {
                echo "<script>alert('File already exists!');
                window.location.href='./profile.php';</script>";
                exit;
            }

            $user_data_query = $db->query("SELECT storage FROM users WHERE email='$email'");
            if ($user_data_query && $user_data_query->num_rows > 0) {
                $user_data = $user_data_query->fetch_assoc();
                $total_storage = $user_data['storage'];
                $used_result = $db->query("SELECT SUM(file_size) AS used FROM `$user_table_name`");
                $row = $used_result->fetch_assoc();
                $used_storage = (float)$row['used'];
                $free_space = $total_storage - $used_storage;

                if ($file_size <= $free_space) {
                    if (move_uploaded_file($location, $target_path)) {
                        
                        $insert_query = "INSERT INTO `$user_table_name` (file_name, file_size) VALUES ('$filename', '$file_size')";
                        $db->query($insert_query);

                        $used_result = $db->query("SELECT SUM(file_size) AS used FROM `$user_table_name`");
                        $row = $used_result->fetch_assoc();
                        $new_used_storage = (float)$row['used'];
                        $update_query = "UPDATE users SET used_storage='$new_used_storage' WHERE email='$email'";
                        $db->query($update_query);

                        header("Location: ./profile.php");
                        exit;
                    } else {
                        echo "<script>alert('Upload failed.'); window.location.href='./profile.php';</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('File too large. Kindly purchase more storage.'); window.location.href='./profile.php';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('User data not found.'); window.location.href='./profile.php';</script>";
                exit;
            }
        }

    } else {
        echo "Login Failed";
        echo "<br><a href='./signup and login form.php'><button style='padding:10px;margin-top:10px;'>Login again</button></a>";
    }
}
?>
