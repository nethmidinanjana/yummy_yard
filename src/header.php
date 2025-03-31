<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>

<body>

    <?php
    session_start();

    ?>
    <!-- Headrer -->

    <nav style="background-color: #F8E559;" class="top-0 left-0 w-full z-50 border">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="../resources/logo.svg" class="h-14" alt="Yummy Yard" />
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-semibold text-2xl flex flex-col p-4 md:p-0 mt-4 border md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 justify-between items-center">
                    <li class="smooth-scroll home-link">
                        <a href="index.php#home" class="block py-2 px-3 text-black rounded md:bg-transparent md:p-0 rajdhani-light " aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="index.php#categories" class="block py-2 px-3 text-black rounded md:hover:bg-transparent md:border-0  md:p-0 md:dark:hover:bg-transparent rajdhani-light ">Categories</a>
                    </li>
                    <li>
                        <a href="index.php#footer" class="block py-2 px-3 text-black rounded md:hover:bg-transparent md:border-0 md:p-0  md:dark:hover:bg-transparent rajdhani-light">Contact Us</a>
                    </li>

                    <div class="flex flex-col relative py-2 hover:cursor-pointer" onclick="NavigateToBasket();">
                        <a href="basket.php">
                            <img src="../resources/basket.svg" alt="Basket Image" class="w-8">
                        </a>
                        <?php
                        require "connection.php";
                        if (isset($_SESSION["u"])) {
                            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_id`='" . $_SESSION["u"]["id"] . "'");
                            $cart_num = $cart_rs->num_rows;

                            if ($cart_num != 0) {
                        ?>
                                <div class="absolute top-6 left-0  text-xs border rounded-full w-5 h-5 flex justify-center items-center bg-white  hover:cursor-pointer"><?php echo $cart_num; ?></div>
                            <?php
                            } else {
                            ?>
                                <div class="absolute top-6 left-0  text-xs border rounded-full w-5 h-5 flex justify-center items-center bg-white  hover:cursor-pointer">0</div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="absolute top-6 left-0  text-xs border rounded-full w-5 h-5 flex justify-center items-center bg-white  hover:cursor-pointer">0</div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="py-2">
                        <a href="account.php">
                            <img src="../resources/user.svg" alt="Basket Image" class="w-8">
                        </a>
                    </div>
                    <div>
                        <a href="all_foods.php">
                            <img src="../resources/9035973_search_circle_sharp_icon.svg" alt="Search Image" class="w-10">
                        </a>
                    </div>


                    <?php


                    if (isset($_SESSION["u"])) {

                        $data = $_SESSION["u"];

                    ?>

                        <a href="signup.php" type="button" class="text-black border bg-white hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-base px-5 py-1 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 rajdhani-light" onclick="signout();">Sign Out</a>

                        <!-- <span class="text-lg-start "><b>Welcome </b><?php echo $data["fname"]; ?></span> | -->



                    <?php

                    } else {

                    ?>

                        <li>
                            <a href="signup.php" type="button" class="block text-white  bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-xl px-5 py-1 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 rajdhani-light ">Sign Up</a>
                        </li>

                    <?php

                    }

                    ?>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Headrer -->

    <script scr="../script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>