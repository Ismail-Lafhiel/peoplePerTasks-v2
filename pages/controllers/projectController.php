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

function show_projects($conn)
{
    $query = "SELECT u.first_name, u.last_name, u.user_type, c.category_name, p.id, p.created_at, p.title, p.description, t.tag_name
    FROM users u
    JOIN projects p ON u.id = p.user_id
    JOIN categories c ON p.category_id = c.id
    JOIN project_tag pt ON p.id = pt.project_id
    JOIN tags t ON pt.tag_id = t.id WHERE u.user_type = 'client'";

    $result = mysqli_query($conn, $query);

    $projects = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $timestamp = strtotime($row['created_at']);
        $now = time();

        $diff = $timestamp - $now;
        $days = floor($diff / (60 * 60 * 24));
        $projectId = $row['id'];
        if (!isset($projects[$projectId])) {
            $projects[$projectId] = [
                'title' => $row['title'],
                'tags' => [],
                'description' => $row['description'],
                'days' => $days,
                'username'=> $row['first_name']." ".$row['last_name'],
                'user_type' => $row['user_type'],
            ];
        }
        $projects[$projectId]['tags'][] = $row['tag_name'];
    }

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