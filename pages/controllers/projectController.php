<?php
require_once(__DIR__ . "/../../resources/db.php");

function add_project($conn, $project_title, $project_description, $imgDestination, $category_id, $user_id)
{
    $imgNewName = null;
    if (isset($_FILES["project_img"]) && $_FILES["project_img"]["error"] === 0) {
        $imgName = $_FILES["project_img"]["name"];
        $imgTmpName = $_FILES["project_img"]["tmp_name"];
        $imgSize = $_FILES["project_img"]["size"];
        $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgActualExt = strtolower($imgExt);
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imgActualExt, $allowed)) {
            if ($imgSize < 125000) {
                $imgNewName = uniqid("", true) . "." . $imgActualExt;
                $imgDestination = '../images/projects_images/' . $imgNewName;
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $project_title = htmlspecialchars($project_title);
        $project_description = htmlspecialchars($project_description);
        $category_id = intval($category_id);
        $user_id = intval($user_id);
        

        $query = "INSERT INTO `projects` (title, description, img_path, category_id, user_id) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssii", $project_title, $project_description, $imgDestination, $category_id, $user_id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: projects.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare the statement";
        }
    }
}

function show_projects($conn)
{
    $query = "SELECT projects.id, projects.title, projects.created_at, projects.img_path, projects.updated_at, categories.category_name, CONCAT(users.first_name, ' ', users.last_name) AS user_name
          FROM projects 
          INNER JOIN categories ON projects.category_id = categories.id 
          INNER JOIN users ON projects.user_id = users.id";

    $result = mysqli_query($conn, $query);

    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $projects;
}

function get_project_for_edit($conn, $project_id)
{
    $query = "SELECT * FROM `projects` WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $project_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        echo "Error: Unable to prepare the statement";
    }
}

function update_project($conn, $project_id, $project_title, $project_description, $imgDestination, $category_id, $user_id)
{
    $imgNewName = null;
    if (isset($_FILES["project_img"]) && $_FILES["project_img"]["error"] === 0) {
        $imgName = $_FILES["project_img"]["name"];
        $imgTmpName = $_FILES["project_img"]["tmp_name"];
        $imgSize = $_FILES["project_img"]["size"];
        $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgActualExt = strtolower($imgExt);
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imgActualExt, $allowed)) {
            if ($imgSize < 125000) {
                $imgNewName = uniqid("", true) . "." . $imgActualExt;
                $imgDestination = '../images/projects_images/' . $imgNewName;
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $project_id = intval($project_id);
        $project_title = htmlspecialchars($project_title);
        $project_description = htmlspecialchars($project_description);
        $category_id = intval($category_id);
        $user_id = intval($user_id);

        $query = "UPDATE `projects` SET title=?, description=?, img_path = ?, user_id=?, category_id=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssiii", $project_title, $project_description, $imgDestination, $category_id, $user_id, $project_id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../pages/projects.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare the statement";
        }
    }
}

function delete_project($conn, $project_id)
{
    $query = "DELETE FROM `projects` WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $project_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Project deleted successfully";
            header("Location: projects.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare the statement";
    }
}
?>