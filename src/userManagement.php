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

                <button type="button" class="w-full focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 mb-2" onclick="window.location.href='manageOrders.php'">Manage Orders</button>

                <button type="button" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="adminSignout()">Signout</button>
            </div>
        </div>


        <div class="content">
            <div class="flex flex-col w-full h-full items-center px-9">

                <div class="w-full mt-5">
                    <span class="text-3xl rajdhani-light font-semibold">Manage Users</span>
                </div>

                <div class="w-full mt-6">

                    <div class="flex flex-col flex-wrap justify-center items-center lg:flex-row gap-4 w-full px-6">

                        <!-- Search Input -->
                        <div class="w-1/2 sm:w-full mt-4">
                            <label for="userSearch" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="userSearch" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type your favourite..." required />
                                <button type="button" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="searchUser()">Search</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="w-full flex flex-wrap justify-center gap-5 mt-6 px-2 py-5 rounded-lg">
                    <div id="resultsContainer" class="w-full h-auto flex sm:flex-col flex-wrap py-2 px-3"></div>

                    <?php
                    $user_rs = Database::search("SELECT * FROM `user`");
                    $user_num = $user_rs->num_rows;

                    for ($j = 0; $j < $user_num; $j++) {
                        $user_data = $user_rs->fetch_assoc();

                    ?>

                        <div class="rounded-lg slide-w-h-hm flex flex-col justify-center items-center border border-gray-300 shadow-lg">
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