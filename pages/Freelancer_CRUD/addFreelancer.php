<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job = $_POST["competences"];
    $user_id = $_POST["user_id"];

    $query = "INSERT INTO `freelancers` (competences, user_id) VALUES (?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $job, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New user created successfully";
            header("Location: ../freelancers.php");
            exit;
        } else {
            echo "Error: Unable to execute the query";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare the statement";
    }
    
    // mysqli_close($conn);
}
?>