<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy Yard | Admin</title>
    <link rel="icon" href="../resources/logo.svg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
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

    require 'connection.php';

    if (isset($_SESSION["au"])) {

        if (isset($_GET["id"])) {

            $pid = $_GET["id"];

            $email = $_SESSION["au"]["email"];

    ?>

            <div class="sidebar flex flex-col justify-between h-full border">
                <div class="flex flex-col justify-center items-center mt-3">
                    <img src="../resources/admin.svg" alt="admin image" class="w-24 h-24">
                    <h3><?php echo ($_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]); ?></h3>
                    <span class="text-xs"><?php echo $email; ?></span>
                    <div class="px-2 mt-3 w-full">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1.5 mt-2 w-full dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="window.location.href='dashboard.php'">Dashboard</button>
                    </div>
                </div>
                <div class=" p-2 bg-gray-100 rounded-lg md:block mt-3">
                    <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900 w-full" onclick="window.location.href='manageProducts.php'">Manage Products</button>

                    <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 w-full" onclick="window.location.href='userManagement.php'">Manage Users</button>

                    <button type="button" class="w-full focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 mb-2" onclick="window.location.href='manageOrders.php'">Manage Orders</button>

                    <button type="button" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="adminSignout()">Signout</button>
                </div>
            </div>


            <div class="content">
                <div class="flex flex-col w-full h-full items-center px-9">

                    <div class="w-full mt-5 mb-3">
                        <span class="text-3xl rajdhani-light font-semibold">Update Products</span>
                    </div>

                    <?php
                    $product_rs = Database::search("SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, foods.*, food_details.*, sub_category.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN categories ON foods.categories_id = categories.id INNER JOIN sub_category ON  foods.sub_category_id = sub_category.id WHERE foods.id = '" . $pid . "' ");

                    $product_num = $product_rs->num_rows;

                    if ($product_num == 1) {
                        $product_data = $product_rs->fetch_assoc();

                    ?>

                        <form class="w-full">

                            <div class="mb-6">
                                <label for="pname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product name</label>
                                <input type="text" id="pname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo ($product_data["food_name"]); ?>" required />
                            </div>
                            <div class="mb-6">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>

                                <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><?php
                                                                                                                                                                                                                                                                                                                                                echo ($product_data["description"]); ?></textarea>
                            </div>
                            <div class="mb-6 flex gap-4">
                                <div class="w-full">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an category</label>

                                    <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " onchange="loadSubCategory()">
                                        <option value="0">Choose a category</option>

                                        <?php
                                        $category_rs = Database::search('SELECT * FROM categories');
                                        $category_num = $category_rs->num_rows;

                                        for ($i = 0; $i < $category_num; $i++) {
                                            $category_data = $category_rs->fetch_assoc();
                                            $selected = $category_data["id"] == $product_data["categories_id"] ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $category_data["id"] ?>" <?php echo $selected; ?>><?php echo $category_data["name"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="w-full">
                                    <label for="sub_category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an sub category</label>
                                    <select id="sub_category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                        <option value="0">Choose a sub category</option>
                                        <?php
                                        $sub_category_rs = Database::search('SELECT * FROM sub_category');
                                        $sub_category_num = $sub_category_rs->num_rows;

                                        for ($i = 0; $i < $sub_category_num; $i++) {
                                            $sub_category_data = $sub_category_rs->fetch_assoc();
                                            $selected = $sub_category_data["id"] == $product_data["sub_category_id"] ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $sub_category_data["id"] ?>" <?php echo $selected; ?>><?php echo $sub_category_data["name"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-6 flex gap-3 w-full">

                                <div class="flex flex-col w-full">
                                    <label for="qty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                    <input type="number" id="qty" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " required value="<?php echo $product_data["qty"] ?>" />
                                </div>

                                <div class="flex flex-col w-full">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                    <input type="number" id="price" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " value="<?php echo $product_data["price"] ?>" required />
                                </div>

                                <div class="flex flex-col w-full">
                                    <label for="size" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select size</label>
                                    <select id="size" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                        <option value="0">Choose a size</option>
                                        <option value="S" <?php echo $product_data["size"] == "S" ? 'selected' : ''; ?>>Small</option>
                                        <option value="M" <?php echo $product_data["size"] == "M" ? 'selected' : ''; ?>>Medium</option>
                                        <option value="L" <?php echo $product_data["size"] == "L" ? 'selected' : ''; ?>>Large</option>
                                        <option value="R" <?php echo $product_data["size"] == "R" ? 'selected' : ''; ?>>Regular</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mb-6 w-full flex flex-col ">

                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add Food Images</label>

                                <?php
                                $image_rs = Database::search("SELECT * FROM food_images WHERE food_images.food_details_id = '" . $product_data["food_details_id"] . "'");

                                $image_urls = [];

                                while ($image_row = $image_rs->fetch_assoc()) {
                                    $image_urls[] = $image_row["image_url"];
                                }

                                $default_image_url = "resources/addprdctimg.png";

                                while (count($image_urls) < 3) {
                                    $image_urls[] = $default_image_url;
                                }
                                ?>

                                <div class="w-full flex justify-center items-center mt-3">
                                    <ul class="flex gap-10 w-full justify-between items-center flex-wrap">
                                        <li class="flex flex-col justify-center items-center border border-gray-400 mb-1">
                                            <img src="../<?php echo $image_urls[0]; ?>" class="img-thumbnail mt-1 mb-1 w-72 h-72" id="i0" />
                                        </li>
                                        <li class="flex flex-col justify-center items-center border border-gray-400 mb-1">
                                            <img src="../<?php echo $image_urls[1]; ?>" class="img-thumbnail mt-1 mb-1 w-72 h-72" id="i1" />
                                        </li>
                                        <li class="flex flex-col justify-center items-center border border-gray-400 mb-1">
                                            <img src="../<?php echo $image_urls[2]; ?>" class="img-thumbnail mt-1 mb-1 w-72 h-72" id="i2" />
                                        </li>
                                    </ul>
                                </div>
                                <div class="w-full d-grid mt-5 flex flex-wrap">
                                    <input type="file" class="hidden" id="imageuploader" multiple />
                                    <label for="imageuploader" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-24 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="changeProductImage();">Upload Images</label>
                                </div>


                            </div>

                            <div class="flex w-full justify-end items-end flex-wrap">
                                <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xl px-36 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" onclick="updateProduct(event, <?php echo $product_data['food_id'] ?>, <?php echo $product_data['food_details_id'] ?>)">Update Product</button>
                            </div>

                        </form>

                    <?php
                    }

                    ?>




                </div>
            </div>
        <?php

        } else {
            echo ("Something went wrong.");
        }
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


    <script src="../script.js"></script>

</body>

</html>