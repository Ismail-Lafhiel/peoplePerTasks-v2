<?php

require_once("../db/conn.php");

$query = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $query);

$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['id']] = $row;
}

// mysqli_close($conn);
?>