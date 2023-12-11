<?php
require_once(__DIR__ . "/../../resources/db.php");

function deleteFreelancer($conn, $freelancer_id)
{
    $query = "DELETE FROM `freelancers` WHERE id = ?";
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id'])) {
            $freelancerId = mysqli_real_escape_string($conn, $_POST['freelancer_id']);
            $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
            $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
            $skills = $_POST['skills'];

            mysqli_begin_transaction($conn);

            // Update the freelancer
            $query = "UPDATE users 
                  SET first_name = ?, last_name = ?
                  WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $firstName, $lastName, $freelancerId);
            mysqli_stmt_execute($stmt);

            if ($stmt) {
                // Delete existing skills for the freelancer from the pivot table
                $deleteQuery = "DELETE FROM skills WHERE user_id = ?";
                $deleteStmt = mysqli_prepare($conn, $deleteQuery);
                mysqli_stmt_bind_param($deleteStmt, "i", $freelancerId);
                mysqli_stmt_execute($deleteStmt);

                // Insert the updated skills for the freelancer into the pivot table
                $insertQuery = "INSERT INTO skills (user_id, skill) VALUES (?, ?)";
                $insertStmt = mysqli_prepare($conn, $insertQuery);
                foreach ($skills as $skill) {
                    mysqli_stmt_bind_param($insertStmt, "is", $freelancerId, $skill);
                    mysqli_stmt_execute($insertStmt);
                }

                // Commit the transaction
                mysqli_commit($conn);

                echo "Freelancer updated successfully";
            } else {
                mysqli_rollback($conn);
                echo "Error updating freelancer";
            }
        } else {
            echo "Freelancer ID not provided";
        }
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
              JOIN skills s ON u.id = s.user_id
              JOIN freelancers f ON f.user_id = u.id
              WHERE f.id = ?";
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