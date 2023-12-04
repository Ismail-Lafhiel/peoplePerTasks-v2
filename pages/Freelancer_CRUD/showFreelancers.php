<?php

require_once("../../resources/db.php");

$query = "SELECT users.first_name, users.last_name,freelancers.competences, freelancers.created_at, freelancers.updated_at, freelancers.id  FROM `freelancers` INNER JOIN `users` on freelancers.user_id = users.id";
$result = mysqli_query($conn, $query);

$freelancers = array();
while ($row = mysqli_fetch_assoc($result)) {
    $freelancers[$row['id']] = $row;
}

// mysqli_close($conn);
?>