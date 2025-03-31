<?php
require 'connection.php';
$data = json_decode(file_get_contents('php://input'), true);

$searchQuery = isset($data['searchInput']) ? $data['searchInput'] : '';

// Build the query
$query = "SELECT * FROM user
WHERE user.fname LIKE '%" . $searchQuery . "%'
   OR user.lname LIKE '%" . $searchQuery . "%'
   OR user.contact_num LIKE '%" . $searchQuery . "%'
   OR user.email LIKE '%" . $searchQuery . "%'";

$result = Database::search($query);
$num = $result->num_rows;

if ($num > 0) {
    echo '<div class="flex flex-wrap justify-center gap-8 mt-8">';

    while ($user_data = $result->fetch_assoc()) {
        echo '<div class="rounded-lg slide-w-h-hm flex flex-col justify-center items-center border border-gray-300 shadow-lg">';
        echo '<img src="../resources/fooddp.svg" alt="DP" class="h-16 w-16">';
        echo '<span class="mt-2 rajdhani-light text-sm font-semibold">' . ($user_data["fname"] . " " . $user_data["lname"]) . '</span>';
        echo '<span class="rajdhani-light text-xs font-medium">' . $user_data["contact_num"] . '</span>';
        echo '<span class="rajdhani-light text-xs font-normal">' . $user_data["email"] . '</span>';

        echo '<div class="w-full px-3 mt-2 flex flex-col">';

        // Conditional button based on status_id
        if ($user_data["status_id"] == 1) {
            echo '<button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full rajdhani-light" data-user-id="' . $user_data['id'] . '" onclick="blockUser(this);">Block</button>';
        } else {
            echo '<button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 w-full rajdhani-light" data-user-id="' . $user_data['id'] . '" onclick="unBlockUser(this);">Unblock</button>';
        }

        echo '</div>'; // Close flex div
        echo '</div>'; // Close card div
    }

    echo '</div>'; // Close flex wrap
} else {
    echo "No results found.";
}
?>
