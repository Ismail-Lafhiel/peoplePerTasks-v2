<?php
require_once(__DIR__ . "/../../resources/db.php");
function deleteFreelancer($conn, $freelancer_id)
{
    $query = "DELETE FROM `users` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $freelancer_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "freelancer deleted successfully";
        header("Location: ../pages/freelancers.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn); // Display error message
    }

}
function updateFreelancer($conn, $freelancerId, $firstName, $lastName, $skills)
{
    mysqli_begin_transaction($conn);

    // Update the freelancer's information
    $query = "UPDATE users 
              SET first_name = ?, last_name = ?
              WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $firstName, $lastName, $freelancerId);
    $updateSuccess = mysqli_stmt_execute($stmt);

    // Delete existing skills for the freelancer from the pivot table
    $deleteQuery = "DELETE FROM user_skill WHERE user_id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $freelancerId);
    $deleteSuccess = mysqli_stmt_execute($deleteStmt);

    // Insert the updated skills for the freelancer into the pivot table
    $insertQuery = "INSERT INTO user_skill (user_id, skill_id) VALUES (?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);
    $insertSuccess = true; // Initialize $insertSuccess
    foreach ($skills as $skill) {
        // Assuming the skills table has an auto-incrementing ID
        $insertSuccess = $insertSuccess && mysqli_stmt_bind_param($insertStmt, "ii", $freelancerId, $skill);
        $insertSuccess = $insertSuccess && mysqli_stmt_execute($insertStmt);
    }

    if ($updateSuccess && $deleteSuccess && $insertSuccess) {
        mysqli_commit($conn);
        echo "Freelancer updated successfully";
    } else {
        mysqli_rollback($conn);
        echo "Error updating freelancer";
    }
}



function getFreelancers($conn)
{
    $freelancers = array();
    // Retrieve freelancer users
    $freelancerUsersQuery = "SELECT * FROM users WHERE user_type = 'freelancer'";
    $freelancerUsersResult = mysqli_query($conn, $freelancerUsersQuery);

    // Loop through each freelancer user
    while ($freelancerUser = mysqli_fetch_assoc($freelancerUsersResult)) {
        $userSkillsQuery = "SELECT s.skill FROM skills s
                    INNER JOIN user_skill us ON s.id = us.skill_id
                    WHERE us.user_id = " . $freelancerUser['id'];
        $userSkillsResult = mysqli_query($conn, $userSkillsQuery);

        $skills = array();
        while ($skill = mysqli_fetch_assoc($userSkillsResult)) {
            $skills[] = $skill['skill'];
        }

        $freelancerUser['skills'] = $skills;
        $sanitizedFreelancerUser = $freelancerUser;
        $freelancers[$sanitizedFreelancerUser['id']] = $sanitizedFreelancerUser;
    }

    return $freelancers;
}

function get_freelancer_for_edit($conn, $freelancer_id)
{
    $query = "SELECT u.id, u.first_name, u.last_name, s.skill
              FROM users u
              JOIN user_skill us ON u.id = us.user_id
              JOIN skills s ON us.skill_id = s.id
              WHERE u.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $freelancer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $freelancerData = $row;
            return $freelancerData;
        } else {
            echo "Freelancer not found";
        }
    } else {
        echo "Error: Unable to prepare the statement";
    }
}



?>