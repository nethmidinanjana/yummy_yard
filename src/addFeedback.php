<?php
session_start();
require "connection.php";

// Check if data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $fid = isset($_POST["fid"]) ? htmlspecialchars($_POST["fid"]) : "";
    $feedback = isset($_POST["f"]) ? htmlspecialchars($_POST["f"]) : "";

    // Validate inputs
    if (empty($feedback)) {
        echo "Please enter a feedback";
    } else {
        // Assuming $_SESSION['u']['id'] contains user ID
        $userId = isset($_SESSION['u']['id']) ? $_SESSION['u']['id'] : 0;

        // Insert into database
        $query = "INSERT INTO `feedback` (`foods_id`, `feedback`, `user_id`) VALUES ('$fid', '$feedback', '$userId')";
        $result = Database::iud($query);

        echo "success";
    }
} else {
    echo "Invalid request";
}
