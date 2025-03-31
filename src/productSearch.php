<?php
require 'connection.php'; // Include your database connection file

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

$category = isset($data['searchCategoryInput']) ? $data['searchCategoryInput'] : '0';
$searchQuery = isset($data['searchInput']) ? $data['searchInput'] : '';

// Build the query
$query = "SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, sub_category.id AS sub_category_id, sub_category.name AS sub_category_name, foods.*, food_details.*, sub_category.* 
          FROM foods 
          INNER JOIN food_details ON foods.id = food_details.foods_id 
          INNER JOIN sub_category ON foods.sub_category_id = sub_category.id 
          WHERE foods.status_id = '1'";

if ($category != '0') {
    $query .= " AND foods.categories_id = " . intval($category);
}

if (!empty($searchQuery)) {
    $query .= " AND foods.name LIKE '%" . $searchQuery . "%'";
}

$result = Database::search($query);
$num = $result->num_rows;

// Display the results
if ($num > 0) {
    echo '<div class="flex flex-wrap justify-center gap-8 mt-8">';

    while ($data = $result->fetch_assoc()) {
        $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM 
                                         (SELECT id, image_url, food_details_id, 
                                         ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num 
                                         FROM food_images WHERE food_details_id = '" . $data["food_details_id"] . "') 
                                         AS RankedFoodImages WHERE row_num = 1");
        $food_data = $food_img_rs->fetch_assoc();

        echo '<div class="rounded-lg slide-w-h-prd border border-gray-300 shadow-lg flex flex-col items-center">';
        echo '<img src="../' . $food_data["image_url"] . '" alt="Food images" class="h-28 w-full object-cover rounded-lg">';
        echo '<span class="mt-2 rajdhani-light text-md font-medium">' . $data["food_name"] . '</span>';
        echo '<div class="w-full px-3 mt-2 flex flex-col">';

        // Update button
        echo '<a href="updateProduct.php?id=' . $data["food_id"] . '" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full rajdhani-light text-center">Update</a>';

        // Re-add or Remove button based on status_id
        if ($data["status_id"] == 2) {
            echo '<button type="button" class="font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 w-full rajdhani-light" data-product-id="' . $data['food_id'] . '" onclick="reAddProduct(this);">Re-add</button>';
        } else {
            echo '<button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full rajdhani-light" data-product-id="' . $data['food_id'] . '" onclick="removeProduct(this);">Remove</button>';
        }

        echo '</div>'; // Close flex div
        echo '</div>'; // Close card div
    }

    echo '</div>'; // Close flex wrap
} else {
    echo "No results found.";
}
?>
