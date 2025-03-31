<?php
require 'connection.php'; // Include your database connection file

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

$category = isset($data['searchCategoryInput']) ? $data['searchCategoryInput'] : '0';
$searchQuery = isset($data['searchInput']) ? $data['searchInput'] : '';
$sortPrice = isset($data['sortPriceInput']) ? $data['sortPriceInput'] : '0';

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

if ($sortPrice == '1') {
    $query .= " ORDER BY food_details.price DESC";
} elseif ($sortPrice == '2') {
    $query .= " ORDER BY food_details.price ASC";
}

$result = Database::search($query);
$num = $result->num_rows;

// Display the results
if ($num > 0) {
    echo '<div class="w-full flex justify-center items-center mt-8">
            <div class="flex flex-wrap justify-center md:flex-col sm:flex-col gap-8" style="margin-bottom: 50px;">';

    while ($data = $result->fetch_assoc()) {
        $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM 
                                         (SELECT id, image_url, food_details_id, 
                                         ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num 
                                         FROM food_images WHERE food_details_id = '" . $data["food_details_id"] . "') 
                                         AS RankedFoodImages WHERE row_num = 1");
        $food_data = $food_img_rs->fetch_assoc();

        echo "<div class='food-cards border rounded-lg shadow border-gray-300'>
                <a href='single_product_view.php?id=" . $data["food_id"] . "'>
                    <img class='rounded-t-lg w-full object-cover' src='../" . $food_data["image_url"] . "' alt='' style='height: 138px;' />
                </a>
                <div class='mt-3 flex flex-col justify-center items-center'>
                    <div class='text-center'>
                        <div class='flex justify-center items-center gap-3'>
                            <h5 class='text-lg font-semibold tracking-tight text-gray-900 dark:text-white rajdhani-light'>" . $data["food_name"] . "</h5>
                            <span class='" . getSizeClass($data["size"]) . " text-xs font-medium me-2 px-2.5 py-0.5 rounded'>" . $data["size"] . "</span>
                        </div>
                        <span class='rajdhani-light'>" . $data["sub_category_name"] . "</span><br>
                        <span class='rajdhani-light text-2xl font-semibold'>Rs. " . $data["price"] . "</span>
                    </div>
                    <div class='flex justify-center items-center w-full'>
                        <a type='button' class='text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 mt-3 py-2.5 text-center me-2 mb-5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900' href='single_product_view.php?id=" . $data["food_id"] . "'>Order Now</a>
                        <button type='button' class='bg-blue-100 border border-gray-300 focus:outline-none hover:bg-blue-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-2 py-1 mb-2' data-modal='addToBasketModal' data-product-id='" . $data['food_id'] . "' onclick='openABModal(this);'>
                            <img src='../resources/add_basket.svg' alt='' class='w-8 h-8'>
                        </button>
                    </div>
                </div>
              </div>

              <div class='modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden' id='addToBasketModal-" . $data['food_id'] . "'>
                <div class='modal-content bg-white p-6 rounded-lg'>
                    <div class='modal-body'>
                        <form>
                            <div class='flex flex-col w-full'>
                                <label for='product-qty-" . $data['food_id'] . "'>Insert Quantity</label>
                                <input type='number' id='product-qty-" . $data['food_id'] . "' class='w-full border border-gray-300 rounded px-2 py-1 mb-4' min='1' value='1'>
                            </div>
                        </form>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='bg-gray-500 text-white px-4 py-2 rounded ml-2' onclick='closeABModal(" . $data['food_id'] . ");'>Close</button>
                        <button type='button' class='bg-blue-500 text-white px-4 py-2 rounded' onclick='addToBasket(" . $data['food_id'] . ");'>Add To Basket</button>
                    </div>
                </div>
              </div>";
    }

    echo '</div>
        </div>';
} else {
    echo "No results found.";
}

function getSizeClass($size) {
    switch ($size) {
        case 'S':
            return 'bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-300 border border-blue-300';
        case 'M':
            return 'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300';
        case 'L':
            return 'bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-300 border border-green-400';
        case 'R':
            return 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 border border-red-300';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-300';
    }
}
?>
