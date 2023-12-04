<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $freelancer_id = $_POST["freelancer_id"];
    $user_id = $_POST["user_id"];
    $job = $_POST["competences"];

    $query = "UPDATE `freelancers` set user_id = ?, competences= ? where id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "isi", $user_id, $job, $freelancer_id);
        
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
    
    mysqli_close($conn);
}
?>
