<?php
require_once("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST["name"];
    $query = "INSERT INTO `categories` (name) VALUES ('$category_name')";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        // mysqli_stmt_bind_param($stmt, "s", $first);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New category created successfully";
            header("Location: ../../admin/categories.php");
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
