<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy Yard</title>
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="input.css">

    <link rel="icon" href="../resources/logo.svg" />
</head>

<body>

    <div class="flex flex-col justify-center items-center">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <?php
            include "header.php";
            ?>
            <div class="flex flex-col justify-center items-center w-full">


                <?php
                // Check if the search query parameter is set and if it's coming from index.php
                if (isset($_GET['query']) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
                ?>
                    <!-- Search section -->
                    <section class="w-full h-auto flex flex-col justify-center items-center mb-5">
                        <div class="w-full justify-center items-center text-center">
                            <h1 class="rajdhani-light text-3xl font-medium mt-10">Search Results</h1>
                        </div>

                        <div class="flex justify-center items-center mt-8 gap-8" id="searchResults">

                            <?php
                            $search_query = htmlspecialchars($_GET['query']);
                            $query = "SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, sub_category.id AS sub_category_id, sub_category.name AS sub_category_name, foods.*, food_details.*, sub_category.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN sub_category ON foods.sub_category_id = sub_category.id  WHERE foods.name LIKE '%" . $search_query . "%'";
                            $result = Database::search($query);


                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $row["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                    $food_data = $food_img_rs->fetch_assoc();
                            ?>

                                    <div class="flex w-full justify-center items-center">
                                        <div class="flex flex-wrap justify-center items-center md:flex-col sm:flex-col gap-8" style="margin-bottom: 50px;">

                                            <?php

                                            ?>
                                            <div class="food-cards border rounded-lg shadow border-gray-300">
                                                <a href='<?php echo "single_product_view.php?id=" . $row["food_id"]; ?>'>
                                                    <img class="rounded-t-lg w-full object-cover" src="../<?php echo $food_data["image_url"] ?>" alt="" style="height: 138px;" />
                                                </a>
                                                <div class="mt-3 flex flex-col justify-center items-center">
                                                    <div class="text-center">
                                                        <div class="flex justify-center items-center gap-3">
                                                            <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white rajdhani-light"><?php echo htmlspecialchars($row['food_name']); ?></h5>
                                                            <span class="<?php switch ($row["size"]) {
                                                                                case 'S':
                                                                                    echo 'bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-300 border border-blue-300';
                                                                                    break;
                                                                                case 'M':
                                                                                    echo 'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300';
                                                                                    break;
                                                                                case 'L':
                                                                                    echo 'bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-300 border border-green-400';
                                                                                    break;
                                                                                case 'R':
                                                                                    echo 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 border border-red-300';
                                                                                    break;
                                                                                default:
                                                                                    echo 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-300';
                                                                                    break;
                                                                            } ?> text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                                                <?php echo $row["size"] ?>
                                                            </span>
                                                        </div>
                                                        <span class="rajdhani-light"><?php echo $row["sub_category_name"] ?></span><br>
                                                        <span class="rajdhani-light text-2xl font-semibold">Rs. <?php echo $row["price"] ?></span>
                                                    </div>
                                                    <div class="flex justify-center items-center w-full">
                                                        <a type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 mt-3 py-2.5 text-center me-2 mb-5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" href='<?php echo "single_product_view.php?id=" . $row["food_id"]; ?>'>Order Now</a>

                                                        <button type="button" class="bg-blue-100 border border-gray-300 focus:outline-none hover:bg-blue-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-2 py-1 mb-2" data-modal="addToBasketModal" data-product-id="<?php echo $row['food_id']; ?>" onclick="openABModal(this);">
                                                            <img src="../resources/add_basket.svg" alt="" class="w-8 h-8">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" id="addToBasketModal-<?php echo $row['food_id']; ?>">
                                                <div class="modal-content bg-white p-6 rounded-lg">
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="flex flex-col w-full">
                                                                <label for="product-qty-<?php echo $row['food_id']; ?>">Insert Quantity</label>
                                                                <input type="number" id="product-qty-<?php echo $row['food_id']; ?>" class="w-full border border-gray-300 rounded px-2 py-1 mb-4" min="1" value="1">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded ml-2" onclick="closeABModal(<?php echo $row['food_id']; ?>);">Close</button>
                                                        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addToBasket(<?php echo $row['food_id']; ?>);">Add To Basket</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<p>No results found for "' . $search_query . '".</p>';
                            }
                            ?>
                        </div>
                    </section>
                <?php } ?>

                <div class="w-full h-auto flex flex-col justify-center items-center mb-5">

                    <div class="w-full flex flex-col justify-center items-center" style="margin-top: 40px;">
                        <span class="rajdhani-light text-3xl font-medium">Search for your favorites!</span>

                        <div class="flex flex-col flex-wrap justify-center items-center lg:flex-row gap-4 w-full px-6">
                            <!-- Category Input -->
                            <div class="w- lg:w-1/4 mt-4">
                                <select name="searchCategoryInput" id="categoryDropdown" class="w-full border rounded-lg p-4 text-sm text-gray-900 border-gray-300 bg-gray-50">
                                    <option value="0">Select category</option>
                                    <?php
                                    $c_rs = Database::search("SELECT * FROM `categories`");
                                    $c_num = $c_rs->num_rows;

                                    for ($x = 0; $x < $c_num; $x++) {
                                        $c_data = $c_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $c_data["id"]; ?>"><?php echo $c_data["name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Search Input -->
                            <div class="w-1/2 sm:w-full mt-4">
                                <label for="searchInput" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="searchInput" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type your favourite..." required />
                                    <button type="button" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="searchFoods()">Search</button>
                                </div>
                            </div>
                            <!-- Sort by Price Input -->
                            <div class="w- lg:w-1/4 mt-4">
                                <select name="sortPriceInput" id="sortPriceDropdown" class="w-full border rounded-lg p-4 text-sm text-gray-900 border-gray-300 bg-gray-50">
                                    <option value="0">Sort by price</option>
                                    <option value="1">High</option>
                                    <option value="2">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex flex-col justify-center items-center" style="width: 90%; ">
            <div id="resultsContainer" class="w-full h-auto flex sm:flex-col flex-wrap py-8 px-3"></div>


                <?php


                $category_rs = Database::search("SELECT * FROM `categories`");
                $category_num  = $category_rs->num_rows;

                for ($y = 0; $y < $category_num; $y++) {

                    $category_data = $category_rs->fetch_assoc();


                ?>

                    <!-- Main Dishes section -->
                    <section id="<?php $category_data["name"] ?>" class="w-full h-auto flex sm:flex-col flex-wrap border rounded-lg py-8 px-3 mb-3">
                        <div class="w-full flex flex-wrap rounded-lg py-2 items-center justify-center">
                            <div class="line"></div>
                            <div class="px-6">
                                <span class="rajdhani-light text-3xl font-medium"><?php echo $category_data["name"]; ?></span>
                            </div>
                            <div class="line"></div>
                        </div>



                        <!-- food cards -->
                        <div class="w-full flex justify-center items-center mt-8">
                            <div class="flex flex-wrap justify-center md:flex-col sm:flex-col gap-8" style="margin-bottom: 50px;">

                                <?php
                                $product_rs = Database::search("SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, sub_category.id AS sub_category_id, sub_category.name AS sub_category_name, foods.*, food_details.*, sub_category.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN sub_category ON foods.sub_category_id = sub_category.id WHERE foods.categories_id = '" . $category_data["id"] . "' AND foods.status_id = '1' ORDER BY foods.date_time_added DESC");

                                $product_num = $product_rs->num_rows;

                                for ($z = 0; $z < $product_num; $z++) {
                                    $product_data = $product_rs->fetch_assoc();

                                    $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $product_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                    $food_data = $food_img_rs->fetch_assoc();
                                ?>
                                    <div class="food-cards border rounded-lg shadow border-gray-300">
                                        <a href='<?php echo "single_product_view.php?id=" . $product_data["food_id"]; ?>'>
                                            <img class="rounded-t-lg w-full object-cover" src="../<?php echo $food_data["image_url"] ?>" alt="" style="height: 138px;" />
                                        </a>
                                        <div class="mt-3 flex flex-col justify-center items-center">
                                            <div class="text-center">
                                                <div class="flex justify-center items-center gap-3">
                                                    <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white rajdhani-light"><?php echo $product_data["food_name"] ?></h5>
                                                    <span class="<?php switch ($product_data["size"]) {
                                                                        case 'S':
                                                                            echo 'bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-300 border border-blue-300';
                                                                            break;
                                                                        case 'M':
                                                                            echo 'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300';
                                                                            break;
                                                                        case 'L':
                                                                            echo 'bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-300 border border-green-400';
                                                                            break;
                                                                        case 'R':
                                                                            echo 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 border border-red-300';
                                                                            break;
                                                                        default:
                                                                            echo 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-300';
                                                                            break;
                                                                    } ?> text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                                        <?php echo $product_data["size"] ?>
                                                    </span>
                                                </div>
                                                <span class="rajdhani-light"><?php echo $product_data["sub_category_name"] ?></span><br>
                                                <span class="rajdhani-light text-2xl font-semibold">Rs. <?php echo $product_data["price"] ?></span>
                                            </div>
                                            <div class="flex justify-center items-center w-full">
                                                <a type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 mt-3 py-2.5 text-center me-2 mb-5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" href='<?php echo "single_product_view.php?id=" . $product_data["food_id"]; ?>'>Order Now</a>

                                                <button type="button" class="bg-blue-100 border border-gray-300 focus:outline-none hover:bg-blue-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-2 py-1 mb-2" data-modal="addToBasketModal" data-product-id="<?php echo $product_data['food_id']; ?>" onclick="openABModal(this);">
                                                    <img src="../resources/add_basket.svg" alt="" class="w-8 h-8">
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" id="addToBasketModal-<?php echo $product_data['food_id']; ?>">
                                        <div class="modal-content bg-white p-6 rounded-lg">
                                            <div class="modal-body">
                                                <form>
                                                    <div class="flex flex-col w-full">
                                                        <label for="product-qty-<?php echo $product_data['food_id']; ?>">Insert Quantity</label>
                                                        <input type="number" id="product-qty-<?php echo $product_data['food_id']; ?>" class="w-full border border-gray-300 rounded px-2 py-1 mb-4" min="1" value="1">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded ml-2" onclick="closeABModal(<?php echo $product_data['food_id']; ?>);">Close</button>
                                                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addToBasket(<?php echo $product_data['food_id']; ?>);">Add To Basket</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>


                    </section>



                <?php
                }
                ?>

            </div>

        </div>
        <?php include 'footer.php'; ?>

        <script>
            // JavaScript to handle modal functionality
            document.querySelectorAll('button[data-modal]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal');
                    document.getElementById(modalId).style.display = 'flex';
                });
            });

            document.querySelectorAll('[data-modal-close]').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.modal').style.display = 'none';
                });
            });

            window.addEventListener('click', function(event) {
                document.querySelectorAll('.modal').forEach(modal => {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                });
            });
        </script>

        <script scr="../script.js"></script>
</body>

</html>