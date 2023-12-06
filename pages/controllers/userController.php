<?php
require_once(__DIR__ . "/../../resources/db.php");
function createUser($conn, $first_name, $last_name, $email, $password, $user_type, $imgDestination, $ville_id)
{
    $imgNewName = null;
    if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] === 0) {
        $imgName = $_FILES["user_avatar"]["name"];
        $imgTmpName = $_FILES["user_avatar"]["tmp_name"];
        $imgSize = $_FILES["user_avatar"]["size"];
        $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgActualExt = strtolower($imgExt);
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imgActualExt, $allowed)) {
            if ($imgSize < 125000) {
                $imgNewName = uniqid("", true) . "." . $imgActualExt;
                $imgDestination = '../images/uploads/' . $imgNewName;
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
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO `users` (first_name, last_name, email, password, user_type, img_path, ville_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $first_name, $last_name, $email, $hashed_password, $user_type, $imgDestination, $ville_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "New user created successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
function getUsers($conn)
{
    $query = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $query);

    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[$row['id']] = $row;
    }

    return $users;
}

function getVilles($conn)
{
    $query = "SELECT * FROM villes";
    $result = mysqli_query($conn, $query);

    $villes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $villes[$row['id']] = $row;
    }

    return $villes;
}
function getUserForEdit($conn, $user_id)
{
    $query = "SELECT * FROM `users` WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $userData = $row;
            return $userData;
        } else {
            echo "User not found";
        }
    } else {
        echo "Error: Unable to prepare the statement";
    }
}
function updateUser($conn, $user_id, $first_name, $last_name, $email, $user_type, $ville_id, $imgDestination)
{
    $imgNewName = null;
    if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] === 0) {
        $imgName = $_FILES["user_avatar"]["name"];
        $imgTmpName = $_FILES["user_avatar"]["tmp_name"];
        $imgSize = $_FILES["user_avatar"]["size"];
        $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgActualExt = strtolower($imgExt);
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imgActualExt, $allowed)) {
            if ($imgSize < 125000) {
                $imgNewName = uniqid("", true) . "." . $imgActualExt;
                $imgDestination = '../images/uploads/' . $imgNewName;
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
    $query = "UPDATE `users` SET first_name=?, last_name=?, email=?, user_type=?, img_path=?, ville_id=? WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssii", $first_name, $last_name, $email, $user_type, $imgDestination, $ville_id, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "User updated successfully";
            header("Location: users.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Unable to prepare the statement";
    }
}
function deleteUser($conn, $user_id)
{
    $query = "DELETE FROM `users` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../pages/users.php");
}
?>