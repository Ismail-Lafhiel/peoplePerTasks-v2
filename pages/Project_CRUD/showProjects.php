<?php

require_once("../../resources/db.php");

$query = "SELECT projects.id, projects.title, projects.created_at, projects.updated_at, categories.name, users.first_name, users.last_name 
          FROM projects 
          INNER JOIN categories ON projects.category_id = categories.id 
          INNER JOIN users ON projects.user_id = users.id";

$result = mysqli_query($conn, $query);

$projects = array();
while ($row = mysqli_fetch_assoc($result)) {
    $projects[$row['id']] = $row;
}

mysqli_close($conn);
?>