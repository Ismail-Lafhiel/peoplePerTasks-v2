<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testemonial_id = $_POST["testemonial_id"];
    
    $query = "DELETE FROM `testemonials` WHERE id = $testemonial_id";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        // mysqli_stmt_bind_param($stmt, "i", $project_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    header("Location: ../testemonials.php");
    mysqli_close($conn);
}
?>