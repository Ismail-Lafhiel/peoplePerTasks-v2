<?php
require_once(__DIR__ . "/../../db/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $bio = $_POST["bio"];

    $imgNewName = null;

    if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] === 0) {
        $imgName = $_FILES["user_avatar"]["name"];
        $imgTmpName = $_FILES["user_avatar"]["tmp_name"];
        $imgSize = $_FILES["user_avatar"]["size"];

        $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgActualExt = strtolower($imgExt);
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imgActualExt, $allowed)) {
            if ($imgSize < 125000) {
                $imgNewName = uniqid("", true) . "." . $imgActualExt;
                $imgDestination = '../../../images/uploads/' . $imgNewName;
                if (move_uploaded_file($imgTmpName, $imgDestination)) {
                    // Image uploaded successfully
                } else {
                    $err = "Error uploading the image";
                }
            } else {
                $err = "Image size is too large";
            }
        } else {
            $err = "Invalid file type. Allowed types: jpg, jpeg, png";
        }
    } else {
        $err = "Error uploading the image";
    }

    $query = "UPDATE `users` SET first_name='$first_name', last_name='$last_name', email='$email', bio='$bio', img_path = '$imgNewName' WHERE id=$user_id";

    if (mysqli_query($conn, $query)) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    header("Location: ../../admin/users.php");
    exit; // Add exit after header to stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET["user_id"];

    $query = "SELECT * FROM `users` WHERE id=$user_id"; // Add WHERE clause to select specific user

    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)){
        $userData = $row; // Store user data directly, no need for an array
    } else {
        echo "User not found";
    }
}
?>
