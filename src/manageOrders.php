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
    require "connection.php";

    if (isset($_SESSION["au"])) {

        $email = $_SESSION["au"]["email"];

    ?>

        <div class="sidebar flex flex-col justify-between h-full border">
            <div class="flex flex-col justify-center items-center mt-3">
                <img src="../resources/admin.svg" alt="admin image" class="w-24 h-24">
                <h3>Nethmi Dinanjana</h3>
                <span class="text-xs">nethmidinanjana@gmail.com</span>
                <div class="px-2 mt-3 w-full">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1.5 mt-2 w-full dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="window.location.href='dashboard.php'">Dashboard</button>
                </div>
            </div>
            <div class=" p-2 bg-gray-100 rounded-lg md:block mt-3">
                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 w-full" onclick="window.location.href='manageProducts.php'">Manage Products</button>

                <button type="button" class="w-full focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 mb-2" onclick="window.location.href='userManagement.php'">Manage Users</button>

                <button type="button" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="adminSignout()">Signout</button>
            </div>
        </div>


        <div class="content">
            <div class="flex flex-col w-full h-full items-center px-9">

                <div class="w-full mt-5">
                    <span class="text-3xl rajdhani-light font-semibold">Manage Orders</span>
                </div>

                <div class="w-full mt-5">

                    <form class="max-w-md mx-auto">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Invoice..." required />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>

                </div>
                <div class="w-full flex flex-wrap justify-center gap-5 mt-6 px-2 py-5 rounded-lg">

                    <?php
                    $order_rs = Database::search("SELECT invoice.qty AS invoice_qty, invoice.status_id AS invoice_status, invoice.*,
                     foods.*, food_details.id AS food_details_id, food_details.*, user.*, 
                user_has_address.* FROM invoice INNER JOIN foods ON invoice.foods_id = foods.id INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN user ON user.id = invoice.user_id INNER JOIN user_has_address ON user.id = user_has_address.user_id WHERE invoice.status_id != 2");

                    $order_num = $order_rs->num_rows;

                    if ($order_num > 0) {
                        for ($i = 0; $i < $order_num; $i++) {
                            $order_data = $order_rs->fetch_assoc();

                            $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $order_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                            $food_data = $food_img_rs->fetch_assoc();

                    ?>

                            <div class="flex flex-col md:flex-row items-center bg-white border border-gray-200 rounded-lg shadow-md md:max-w-xl ">
                                <img class="object-cover w-full md:w-48 h-full rounded-l-lg " src="../<?php echo $food_data["image_url"] ?>" alt="">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <span class="text-sm font-semibold tracking-tight text-gray-600 dark:text-white">Order ID - <?php echo $order_data["order_id"] ?></span>
                                    <span class="text-base font-medium tracking-tight text-gray-700 dark:text-white">Product - <?php echo $order_data["name"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Quantity - <?php echo $order_data["invoice_qty"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Payment - Rs. <?php echo $order_data["total"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Customer - <?php echo $order_data["fname"] . " " . $order_data["lname"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Contact No: - <?php echo $order_data["contact_num"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Date & Time - <?php echo $order_data["date_time"] ?></span>
                                    <span class="text-sm font-normal tracking-tight text-gray-900 dark:text-white">Address - <?php echo $order_data["line1"] . " " . $order_data["line2"] ?></span>
                                    <?php
                                    $status = $order_data["invoice_status"];

                                    if ($status == 1) {
                                    ?>
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="changeInvoiceStatus('<?php echo $order_data['order_id']; ?>');" id="btn<?php echo $order_data['order_id']; ?>">Confirm Order</button>
                                    <?php
                                    } else if ($status == 3) {
                                    ?>
                                        <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" onclick="changeInvoiceStatus('<?php echo $order_data['order_id']; ?>');" id="btn<?php echo $order_data['order_id']; ?>">On Delivery</button>
                                    <?php
                                    } else if ($status == 4) {
                                    ?>
                                        <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" onclick="changeInvoiceStatus('<?php echo $order_data['order_id']; ?>');" id="btn<?php echo $order_data['order_id']; ?>">Delivered</button>
                                    <?php
                                    } else if ($status == 5) {
                                    ?>
                                        <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="changeInvoiceStatus('<?php echo $order_data['order_id']; ?>');" id="btn<?php echo $order_data['order_id']; ?>">Delete Order</button>

                                    <?php
                                    }

                                    ?>
                                </div>
                            </div>


                        <?php
                        }
                    } else {
                        ?>
                        <span class="bg-red-100 text-red-800 text-lg font-medium me-2 px-5 py-2 .5 rounded dark:bg-red-900 dark:text-red-300 mt-5">No orders</span>
                    <?php
                    }
                    ?>

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

    <script src="../script.js"></script>

</body>

</html>