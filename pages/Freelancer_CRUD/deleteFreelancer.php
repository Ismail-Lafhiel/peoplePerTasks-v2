<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $freelancer_id = $_POST["freelancer_id"];
    
    $query = "DELETE FROM `freelancers` WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $freelancer_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    header("Location: ../freelancers.php");
    // mysqli_close($conn);
}
?>