<?php
require_once("../../resources/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST["project_id"];
    $project_title = $_POST["project_title"];
    $project_description = $_POST["project_description"];
    $category_id = $_POST["category_id"];
    $user_id = $_POST["user_id"];

    $query = "UPDATE `projects` SET title=?, description=?, user_id = ?, category_id = ? WHERE id=?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssiii", $project_title, $project_description, $user_id, $project_id, $category_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "User updated successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    
    header("Location: ../projects.php");
    mysqli_close($conn);
}
?>
