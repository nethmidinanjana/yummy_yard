<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy Yard | Admin</title>
    <link rel="icon" href="../resources/logo.svg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="input.css">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <style>
        .content {
            z-index: 1;
            position: relative;
        }
    </style>
</head>

<body style="margin: 0;">

    <?php

    session_start();
    require "connection.php";

    if (isset($_SESSION["au"])) {

        $email = $_SESSION["au"]["email"];

    ?>

        <div class="sidebar flex flex-col justify-between h-full border">
            <div class="flex flex-col justify-center items-center mt-3">
                <img src="../resources/admin.svg" alt="admin image" class="w-24 h-24">
                <h3><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"] ?></h3>
                <span class="text-xs"><?php echo $_SESSION["au"]["email"] ?></span>
            </div>
            <div class=" p-2  bg-gray-100 rounded-lg md:block mt-3">
                <button type="button" class="w-full focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 mb-2" onclick="window.location.href='manageOrders.php'">Manage Orders</button>

                <button type="button" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="adminSignout()">Signout</button>
            </div>
        </div>


        <div class="content">
            <div class="flex flex-col w-full h-full items-center">
                <div class="container mx-auto mt-5">
                    <div class="flex flex-wrap justify-center lg:flex-nowrap gap-9">
                        <div class="w-96 bg-blue-500 flex items-center justify-center text-white p-5 rounded-lg">
                            <div class="w-full h-auto flex justify-between px-4">
                                <div class="flex flex-col">
                                    <?php
                                    $f_rs = Database::search("SELECT * FROM `foods` WHERE `status_id` != '2'");
                                    $f_num = $f_rs->num_rows;
                                    ?>
                                    <span class="rajdhani-light text-2xl font-medium">Total Products</span>
                                    <span class="text-4xl font-semibold mt-2"><?php echo $f_num; ?></span>
                                </div>
                                <div>
                                    <img src="../resources/dish.svg" alt="dish icon" class="w-28 h-20">
                                </div>
                            </div>
                        </div>
                        <div class="w-96 bg-green-500 flex items-center justify-center text-white p-5 rounded-lg">
                            <div class="w-full h-auto flex justify-between px-4">
                                <div class="flex flex-col">
                                    <span class="rajdhani-light text-2xl font-medium">Monthly Orders</span>

                                    <?php
                                    $i_rs = Database::search("SELECT * FROM invoice WHERE YEAR(date_time) = YEAR(CURDATE()) AND MONTH(date_time) = MONTH(CURDATE()) ");
                                    $i_num = $i_rs->num_rows;
                                    ?>
                                    <span class="text-4xl font-semibold mt-2"><?php echo $i_num; ?></span>
                                </div>
                                <div>
                                    <img src="../resources/delivery.svg" alt="delivery icon" class="w-28 h-20">
                                </div>
                            </div>
                        </div>
                        <div class="w-96 bg-red-500 flex items-center justify-center text-white p-5 rounded-lg">
                            <div class="w-full h-auto flex justify-between px-4">
                                <div class="flex flex-col">
                                    <span class="rajdhani-light text-2xl font-medium">Monthly Income</span>
                                    <?php
                                    $t_rs = Database::search("SELECT SUM(total) AS total_sum FROM invoice WHERE YEAR(date_time) = YEAR(CURDATE()) AND MONTH(date_time) = MONTH(CURDATE()) ");
                                    $t_data = $t_rs->fetch_assoc();
                                    ?>
                                    <span class="text-4xl font-semibold mt-2">Rs. <?php echo $t_data["total_sum"]; ?></span>
                                </div>
                                <div>
                                    <img src="../resources/money.svg" alt="money icon" class="w-24 h-16">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full h-auto flex items-center">
                    <div class="mx-auto  mt-4" style="width: 95%;">
                        <div class="border rounded-lg px-6 lg:px-0 py-6 ">
                            <div class="w-full flex flex-wrap justify-between">
                                <h1 class="mb-2 rajdhani-light text-xl font-medium">All Products</h1>
                                <div class="flex justify-center items-center">
                                    <a href="manageProducts.php">See All</a>
                                    <img src="../resources/arrow-right.svg" alt="arrow right" class="w-9 h-5">
                                </div>
                            </div>
                            <div class="slider-container py-3">
                                <div class="slider">
                                    <?php
                                    $product_rs = Database::search("SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, sub_category.id AS sub_category_id, sub_category.name AS sub_category_name, categories.name AS category_name, foods.*, food_details.*, sub_category.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN sub_category ON foods.sub_category_id = sub_category.id
                                    INNER JOIN categories ON foods.categories_id = categories.id
                                     ORDER BY foods.date_time_added DESC");

                                    $product_num = $product_rs->num_rows;

                                    for ($i = 0; $i < $product_num; $i++) {
                                        $product_data = $product_rs->fetch_assoc();

                                        $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $product_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                        $food_data = $food_img_rs->fetch_assoc();

                                        // Generate unique modal ID based on food ID
                                        $modal_id = "productDetailsModal" . $product_data["food_id"];
                                    ?>
                                        <div class="slide slide-w-h-prd border border-gray-300 shadow-lg flex flex-col items-center">
                                            <!-- Button to open modal with dynamic data-modal attribute -->
                                            <button type="button" data-modal="<?php echo $modal_id; ?>" class="h-28 w-full object-cover rounded-lg">
                                                <img src="../<?php echo $food_data["image_url"]; ?>" alt="Food images" class="h-28 w-full object-cover rounded-lg">
                                            </button>

                                            <!-- Display product name -->
                                            <span class="mt-2 rajdhani-light text-md font-medium"><?php echo $product_data["food_name"]; ?></span>
                                            <div class="w-full px-3 mt-2 flex flex-col">
                                                <!-- Update product link -->
                                                <a href='<?php echo "updateProduct.php?id=" . $product_data["food_id"]; ?>' class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1  mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full rajdhani-light">Update</a>

                                                <?php
                                                // Display different buttons based on product status
                                                if ($product_data["status_id"] == 2) {
                                                ?>
                                                    <!-- Re-add button -->
                                                    <button type="button" class="font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 w-full rajdhani-light" data-product-id="<?php echo $product_data['food_id']; ?>" onclick="reAddProduct(this);">Re-add</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <!-- Remove button -->
                                                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full rajdhani-light" data-product-id="<?php echo $product_data['food_id']; ?>" onclick="removeProduct(this);">Remove</button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <!-- Product Details Modal with dynamic ID -->
                                        <div class="modal" id="<?php echo $modal_id; ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <span class="modal-title">Product Details</span>
                                                    <button class="modal-close" data-modal-close>&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="flex flex-col w-full">
                                                            <label for="detail-product-name">Name: <?php echo $product_data["food_name"] ?></label>
                                                        </div>
                                                        <div class="flex flex-col w-full flex-wrap">
                                                            <label for="detail-product-description">Description: </label>
                                                            <textarea name="" id=""><?php echo $product_data["description"] ?></textarea>
                                                        </div>
                                                        <div class="flex mb-2 w-full gap-2">
                                                            <div class="flex flex-col w-full">
                                                                <label for="detail-product-category">Category: <?php echo $product_data["category_name"] ?></label>
                                                            </div>
                                                            <div class="flex flex-col w-full">
                                                                <label for="detail-product-sub-category">Sub Category: <?php echo $product_data["sub_category_name"] ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="flex w-full gap-2">
                                                            <div class="w-full">
                                                                <label for="detail-product-qty">Product Quantity: <?php echo $product_data["qty"] ?></label>
                                                            </div>
                                                            <div class="w-full">
                                                                <label for="detail-product-price">Product Price: <?php echo $product_data["price"] ?></label>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="close-button" data-modal-close>Close</button>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                        <!-- Button below the div -->
                        <div class="flex justify-end items-end mt-4 w-full">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-14 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 rajdhani-light" data-modal="addProductModal" onclick="window.location.href='addProduct.php'">Add Product</button>
                        </div>
                    </div>
                </div>



                <div class=" w-full h-auto flex items-center">
                    <div class="mx-auto px-6 lg:px-0 py-6 border rounded-lg mt-4" style="width: 95%;">
                        <div class="w-full flex flex-wrap justify-between">
                            <h1 class="mb-2 rajdhani-light text-xl font-medium">All Users</h1>
                            <div class="flex justify-center items-center">
                                <a href="userManagement.php">See All</a>
                                <img src="../resources/arrow-right.svg" alt="arrow right" class="w-9 h-5">
                            </div>
                        </div>
                        <div class="slider-container py-3">
                            <div class="slider">
                                <?php
                                $user_rs = Database::search("SELECT * FROM `user`");
                                $user_num = $user_rs->num_rows;

                                for ($j = 0; $j < $user_num; $j++) {
                                    $user_data = $user_rs->fetch_assoc();

                                ?>
                                    <div class="slide slide-w-h-hm flex flex-col flex-wrap justify-center items-center border border-gray-300 shadow-lg">
                                        <img src="../resources/fooddp.svg" alt="DP" class="h-16 w-16  ">
                                        <span class="mt-2 rajdhani-light text-sm font-semibold"><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span>
                                        <span class="rajdhani-light text-xs font-medium"><?php echo ($user_data["contact_num"]); ?></span>
                                        <span class="rajdhani-light text-xs font-normal"><?php echo ($user_data["email"]); ?></span>
                                        <div class="w-full px-3 mt-2 flex flex-col">
                                            <?php
                                            if ($user_data["status_id"] == 1) {
                                            ?>
                                                <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full rajdhani-light" data-user-id="<?php echo $user_data['id']; ?>" onclick="blockUser(this);">Block</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-1 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 w-full rajdhani-light" data-user-id="<?php echo $user_data['id']; ?>" onclick="unBlockUser(this);">Unblock</button>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full mt-8 flex-wrap" style="width: 95%;">
                    <div class="flex-1 w-14 px-12 flex-wrap">
                        <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900 w-full rajdhani-light" data-modal="addCategoryModal">Add New Category</button>
                    </div>
                    <div class="flex-1 w-64 px-12 flex-wrap">
                        <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 w-full rajdhani-light" data-modal="addSpecialModal">Add Today’s Special</button>
                    </div>

                </div>

                <!-- Add New Category Modal -->
                <div class="modal" id="addCategoryModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="modal-title">Add New Category</span>
                            <button class="modal-close" data-modal-close>&times;</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="flex w-full items-end gap-2 justify-end">
                                    <div class="flex flex-col w-full">
                                        <label for="category_name">Add Main Category</label>
                                        <input type="text" id="category_name" placeholder="Type Main Category Name...">
                                    </div>
                                    <div>
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mb-1" onclick="addMainCategory()">Add</button>
                                    </div>

                                </div>
                                <div class="flex w-full items-end gap-2 justify-end">
                                    <div class="flex flex-col w-full">

                                        <label for="sub_category_name">Add Sub Category</label>
                                        <div class="w-full flex gap-2 justify-center items-center">

                                            <div>
                                                <select name="category" id="category" class="py-2 px-2 border border-gray-400 rounded text-gray-600">
                                                    <option value="0">Select Category</option>

                                                    <?php
                                                    $c_rs = Database::search("SELECT * FROM `categories`");
                                                    $c_num = $c_rs->num_rows;

                                                    for ($x = 0; $x < $c_num; $x++) {
                                                        $c_data = $c_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $c_data["id"] ?>"><?php echo $c_data["name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div>
                                                <input type="text" id="sub_category_name" placeholder="Type Sub Category Name..." class="py-1 px-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-1 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" onclick="addSubC();">Add</button>
                                    </div>
                                </div>

                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="close-button" data-modal-close>Close</button>
                    </div>
                </div>
            </div>

            <!-- Add Today’s Special Modal -->
            <div class="modal" id="addSpecialModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title">Add Today’s Special</span>
                        <button class="modal-close" data-modal-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="specialForm">
                            <div class="flex flex-col w-full">
                                <label for="special-id">Product ID</label>
                                <input type="text" id="special-id" name="special-id" placeholder="Product ID">
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="special-title">Title</label>
                                <input type="text" id="special-title" name="special-title" placeholder="Product Title">
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="special-product-description">Description</label>
                                <textarea id="special-product-description" name="special-product-description" placeholder="Product Description"></textarea>
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload Image</label>
                                <input class="block w-full text-sm px-2" id="file_input" name="file_input" type="file">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="close-button" data-modal-close>Close</button>
                        <button class="save-button" onclick="addTodaySpecial()">Save</button>
                    </div>
                </div>
            </div>






        </div>
        </div>

    <?php

    } else {
    ?>

        <div class="h-screen w-full flex justify-center items-center bg-red-600">
            <div class="text-center">
                <h1 class="text-4xl text-white">Access Denied</h1>
            </div>
        </div>
    <?php
    }
    ?>

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
    <script src="../script.js"></script>
</body>

</html>