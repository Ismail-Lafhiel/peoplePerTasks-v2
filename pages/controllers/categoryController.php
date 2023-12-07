<?php
require_once(__DIR__ . "/../../resources/db.php");
function addCategory($conn, $category_name) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category_name = htmlspecialchars($_POST["name"]); // Protect against XSS

        $query = "INSERT INTO `categories` (category_name) VALUES (?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $category_name);

            if (mysqli_stmt_execute($stmt)) {
                echo "New category created successfully";
                header("location: categories.php");
                exit;
            } else {
                return "Error: " . mysqli_error($conn);
            }

            // mysqli_stmt_close($stmt);
        } else {
            return "Error: Unable to prepare the statement";
        }
    }
}

function getCategories($conn) {
    $query = "SELECT * FROM `categories`";
    $result = mysqli_query($conn, $query);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Sanitize user input to prevent XSS
        $sanitizedRow = array_map('htmlspecialchars', $row);
        $categories[$sanitizedRow['id']] = $sanitizedRow;
    }
    return $categories;
}
?>
