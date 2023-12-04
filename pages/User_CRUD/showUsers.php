<?php

require_once("../db/conn.php");

$query = "SELECT * FROM `users`";
$result = mysqli_query($conn, $query);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[$row['id']] = $row;
}

// mysqli_close($conn);
?>