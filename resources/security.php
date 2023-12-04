<?
require_once("session.php");

if (!isset($_SESSION["id"])) {
    header('location: ../pages/login.php');
}

if (isset($_SESSION["user_type"]) == "freelancer") {
    header("Location: ../pages/index.php");
}

?>