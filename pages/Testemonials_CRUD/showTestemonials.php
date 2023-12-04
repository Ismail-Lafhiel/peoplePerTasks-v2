<?php

require_once("../../resources/db.php");

$query = "SELECT testemonials.id, testemonials.comment, testemonials.created_at, testemonials.updated_at, users.first_name, users.last_name, users.img_path
          FROM testemonials 
          INNER JOIN users ON testemonials.user_id = users.id ORDER BY testemonials.id DESC";

$result = mysqli_query($conn, $query);

$testemonials = array();
while ($row = mysqli_fetch_assoc($result)) {
    $testemonials[$row['id']] = $row;
}

// mysqli_close($conn);
?>