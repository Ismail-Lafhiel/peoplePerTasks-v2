<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_title = $_POST["project_title"];
    $project_description = $_POST["project_description"];
    $category_id = $_POST["category_id"];
    $user_id = $_POST["user_id"];
    $query = "INSERT INTO `projects` (title, description, category_id, user_id) VALUES (?,?,?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssii", $project_title,$project_description,$category_id, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New project created successfully";
            header("Location: ../projects.php");
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
