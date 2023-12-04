<?php
require_once("../conn.php");

if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];
    $query = "DELETE FROM `users` WHERE id = $user_id";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
}
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $user_id = $_POST["user_id"];
    
//     $query = "DELETE FROM `users` WHERE id = $user_id";
    
//     if ($stmt = mysqli_prepare($conn, $query)) {
//         // mysqli_stmt_bind_param($stmt, "i", $user_id);
        
//         if (mysqli_stmt_execute($stmt)) {
//             echo "User deleted successfully";
//         } else {
//             echo "Error: " . $query . "<br>" . mysqli_error($conn);
//         }
        
//         mysqli_stmt_close($stmt);
//     } else {
//         echo "Error: " . $query . "<br>" . mysqli_error($conn);
//     }
    
//     header("Location: ../../admin/users.php");
//     mysqli_close($conn);
// }
?>
