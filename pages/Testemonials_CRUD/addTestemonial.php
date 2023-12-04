<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST["comment"];
    $user_id = $_POST["user_id"];
    $query = "INSERT INTO `testemonials` (comment, user_id) VALUES (?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $comment, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New testemonial created successfully";
            header("Location: ../testemonials.php");
            exit;
        } else {
            echo "Error: Unable to execute the query";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare the statement";
    }
    
    mysqli_close($conn);
}
?>