<?php
require_once(__DIR__ . "/../resources/db.php");

function add_project($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $project_title = htmlspecialchars($_POST["project_title"]);
        $project_description = htmlspecialchars($_POST["project_description"]);
        $category_id = intval($_POST["category_id"]);
        $user_id = intval($_POST["user_id"]);

        $query = "INSERT INTO `projects` (title, description, category_id, user_id) VALUES (?,?,?, ?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssii", $project_title, $project_description, $category_id, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "New project created successfully";
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
    $query = "SELECT projects.id, projects.title, projects.created_at, projects.updated_at, categories.name, users.first_name, users.last_name 
          FROM projects 
          INNER JOIN categories ON projects.category_id = categories.id 
          INNER JOIN users ON projects.user_id = users.id";

    $result = mysqli_query($conn, $query);

    $projects = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[$row['id']] = $row;
    }

    return $projects;
}
function get_project_for_edit($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_project'])) {
        $project_id = intval($_GET["edit_project"]);

        $query = "SELECT * FROM `projects` WHERE id=?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $project_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                return $row;
            } else {
                echo "Project not found";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare the statement";
        }
    }
}
function update_project($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['edit_id'])) {
            $project_id = $_GET["edit_id"];

            $query = "SELECT * FROM `projects` WHERE id=$project_id"; // Add WHERE clause to select specific project

            $result = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result)) {
                $projectData = $row; // Store project data directly, no need for an array
            } else {
                echo "project not found";
            }
            return $projectData;
        }

    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"])) {
        $project_id = intval($_POST["project_id"]);
        $project_title = htmlspecialchars($_POST["project_title"]);
        $project_description = htmlspecialchars($_POST["project_description"]);
        $category_id = intval($_POST["category_id"]);
        $user_id = intval($_POST["user_id"]);

        $query = "UPDATE `projects` SET title=?, description=?, user_id=?, category_id=? WHERE id=?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssiii", $project_title, $project_description, $user_id, $category_id, $project_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "Project updated successfully";
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
function delete_project($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_project_id"])) {
        $project_id = intval($_POST["delete_project_id"]);

        $query = "DELETE FROM `projects` WHERE id=?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $project_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "Project deleted successfully";
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
?>