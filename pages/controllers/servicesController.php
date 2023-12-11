<?php 

require_once(__DIR__ . "/../../resources/db.php");
if(isset($_POST["input"])){
    $input = $_POST["input"];

    $query = "SELECT * from projects where title LIKE '{input}%'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $data = array();
        while($row = mysqli_fetch_assoc($result)){
            $data[$row] = $row;
        }
        header("Location: ../pages/projects.php");
    }else{
        echo"<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 text-center' role='alert'>
            No results found
      </div>";
    }
}
?>