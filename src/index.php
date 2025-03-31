<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy Yard</title>
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="input.css">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

    <link rel="icon" href="../resources/logo.svg" />
</head>

<body style="overflow-x: hidden; ">

    <!-- Hero section -->
    <section id="home" class="bg-cover bg-center h-screen w-full flex justify-center items-center" style="background-image: url('../resources/bg.svg')">

        <?php include "navbar.php";
        ?>

        <div class="w-full h-auto flex flex-col justify-center items-center">
            <div class="rounded-lg text-center flex-col p-5" style="background-color: rgba(0, 0, 0, 0.39); margin-top: 110px; ">
                <div class="hero-padding  hero-div-animate">
                    <span class="text-white almendra-sc-regular " style="font-size: 65px;">Welcome to </span><br>
                    <span class="text-white rancho-regular" style="font-size: 55px;"><span class="text-yellow-400">Y</span>ummy <span class="text-yellow-400">Y</span>ard!</span>
                    <p class="text-white raleway text-[24px]">Where Every Bite Sparks Culinary Ecstasy and Pure <br />
                        Satisfaction!</p>
                    <div class="mt-3">
                        <!-- Search -->

                        <form class="flex items-center max-w-sm mx-auto" action="all_foods.php" method="GET">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" name="query" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search your favorites..." required />
                            </div>
                            <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-yellow-400 rounded-lg border border-yellow-400 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-400 dark:bg-yellow-400 dark:hover:bg-yellow-400 dark:focus:ring-yellow-400">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>


                        <!-- Search -->
                    </div>

                    <div class="mt-8">
                        <button type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-6 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"><span class="raleway text-lg" onclick="scrollToAllFoods();">Explore Foods</span></button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- About -->
    <section id="about" class="w-full h-full flex justify-center items-center frame-container " style="background-color: #F8E559;">
        <div class="flex md:flex-col sm:flex-col justify-center items-center flex-container about-div-animate" style="width: 90%;">
            <div class="w-full flex flex-wrap justify-center md:flex-col sm:flex-col flex-item-left" style="margin-top: 60px; margin-bottom: 40px;">
                <div style="margin-left: 40px; margin-right: 10px;">
                    <span class="raleway font-semibold text-3xl">Explore Flavorful <br /> Adventures at <span class="text-yellow-500">Yummy</span> Yard!</span>
                    <p class="mt-8 rajdhani-light text-lg font-medium">Step into Yummy Yard, a realm where gastronomic wonders await. Our chefs, fueled by passion and creativity, meticulously craft each dish to tantalize your taste buds. From savory starters to decadent desserts, every bite is a celebration of culinary excellence. Immerse yourself in our warm ambiance and embark on a sensory journey unlike any other. Join us at Yummy Yard, where each visit promises an unforgettable culinary adventure.</p>
                </div>
            </div>
            <div class="md:w-full sm:w-full flex justify-center items-center flex-item-right" style="margin-top: 60px; margin-bottom: 40px;">
                <img src="../resources/tasty-burger.svg" alt="Burger Image" style="width: 75%;">
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="w-full h-auto flex justify-center items-center " style="background-image: linear-gradient(to bottom, #F8E559, #000000);">

        <div style="margin-top: 60px; margin-bottom: 60px; width: 80%; " class="flex flex-col justify-center items-center category-div-animate">
            <span class="rajdhani-light text-5xl font-medium">Categories</span>

            <div>

                <div class="flex items-center justify-center w-full h-full py-24 sm:py-8 px-4">
                    <div class="w-full relative flex items-center justify-center">
                        <button aria-label="slide backward" class="absolute z-30 left-0 ml-10 focus:outline-none focus:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 cursor-pointer px-5 py-5" style="background-color:#000000;" id="prev">
                            <svg class="text-white" width="10" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden">
                            <div id="slider" class="h-full flex lg:gap-8 md:gap-6 gap-14 items-center justify-start transition ease-out duration-700">
                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/main-dishes2.jpg" alt="sitting area" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#4" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <span class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Main Dishes</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/pizza.jpg" alt="sitting area" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#Pizza" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Pizza</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/meats-bites.jpg" alt="sitting area" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#3" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Meats & Bites</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/Vegetarian food.svg" alt="black chair and white table" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#5" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Vegetarian Foods</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/cocktail-topped-with-orange-slice.svg" alt="sitting area" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#Drinks" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Drinks</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>



                                <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                    <img src="../resources/desserts.svg" alt="sitting area" class="object-cover object-center w-full" style="width: 360px; height:360px;" />
                                    <div class="absolute w-full h-full p-6">
                                        <div class="flex h-full items-end pb-6">
                                            <a href="all_foods.php#6" style="background-color: #000000; padding:15px;" class="rounded border border-white">
                                                <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900 rajdhani-light">Desserts</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button aria-label="slide forward" class="absolute z-30 right-0 mr-10 focus:outline-none focus:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400  px-5 py-5" id="next" style="background-color:#000000;">
                            <svg class="text-white" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Crowd Favorite -->
    <section class="w-full h-full flex flex-col justify-center items-center" style="background-color: #F8E559;">
        <div style="margin-top: 80px; margin-bottom: 50px; ">
            <span class="rajdhani-light text-5xl font-medium about-div-animate">Crowd Favorite</span>
        </div>


        <div class="flex flex-wrap justify-center md:flex-col sm:flex-col gap-5 " style="margin-bottom: 50px;">

            <div class="max-w-xs border rounded-lg shadow fav-div-animate" style="border-color: #000000; ">
                <a href="#">
                    <img class="rounded-t-lg" src="../resources/seafood-pizza-with-tomato-sauce-variety-seafood-selection.svg" alt="" />
                </a>
                <div class="p-8 flex flex-col justify-center items-center">

                    <h5 class="text-3xl font-medium tracking-tight text-gray-900 dark:text-white rajdhani-light">Seafood-pizza</h5>
                    <span class="rajdhani-light mb-3">Pizza</span>
                    <span class="rajdhani-light text-2xl font-semibold mb-3">Rs. 1200</span>

                    <div>
                        <a href='<?php echo "single_product_view.php?id=1" ?>' type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" style="width:230px;">Order Now</a>
                    </div>

                </div>
            </div>

            <div class="max-w-xs border rounded-lg shadow fav-div-animate" style="border-color: #000000; ">
                <a href="#">
                    <img class="rounded-t-lg" src="../resources/kottu.svg" alt="" />
                </a>
                <div class="p-8 flex flex-col justify-center items-center">
                    <h5 class="text-3xl font-medium tracking-tight text-gray-900 dark:text-white rajdhani-light">Egg Kottu</h5>
                    <span class="rajdhani-light mb-3">Main Dishes</span>
                    <span class="rajdhani-light text-2xl font-semibold mb-3">Rs. 750</span>

                    <div>
                        <a href='<?php echo "single_product_view.php?id=31" ?>' type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" style="width:230px;">Order Now</a>
                    </div>

                </div>
            </div>

            <div class="max-w-xs border rounded-lg shadow fav-div-animate" style="border-color: #000000; ">
                <a href="#">
                    <img class="rounded-t-lg" src="../resources/rice.svg" alt="" />
                </a>
                <div class="p-8 flex flex-col justify-center items-center">

                    <h5 class="text-3xl font-medium tracking-tight text-gray-900 dark:text-white rajdhani-light">Egg Fried-rice</h5>
                    <span class="rajdhani-light mb-3">Main Dishes</span>
                    <span class="rajdhani-light text-2xl font-semibold mb-3">Rs. 530</span>

                    <div>
                        <a href='<?php echo "single_product_view.php?id=32" ?>' type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" style="width:230px;">Order Now</a>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Today’s special -->
    <section class="w-full h-auto flex justify-center items-center" style="background-color: #F8E559;">

        <?php

        $special_rs = Database::search("SELECT * FROM `todays_special`");
        $special_num = $special_rs->num_rows;

        while ($row = $special_rs->fetch_assoc()) {
            $title = $row['title'];
            $description = $row['description'];
            $img_url = $row['img_url'];
            $foods_id = $row['foods_id'];
        }

        ?>

        <div class="flex justify-center items-center flex-container " style="width: 80%; margin-top: 60px; margin-bottom: 60px;">
            <div class="w-1/2 flex flex-col justify-center items-center text-center flex-item-left category-div-animate">
                <span class="rancho-regular font-medium text-5xl">Today’s special </span>
                <span class="raleway text-2xl" style="margin-top: 20px; margin-bottom:20px;"><?php echo $title ?></span>
                <p class="rajdhani-light text-lg"><?php echo $description ?></p>

                <a href='<?php echo "single_product_view.php?id=" . $foods_id; ?>' type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-8 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" style="margin-top: 30px;"><span class="raleway text-xl">Order Now</span></a>
            </div>
            <div class="w-1/2 flex justify-center items-center flex-item-right special-div-animate">
                <img src="../<?php echo $img_url ?>" alt="Today's speacial food poster" style="height: 500px;">
            </div>
        </div>
    </section>

    <!-- Ending -->
    <section class="flex flex-col justify-center items-center" style="background-image: linear-gradient(to bottom, #F8E559, #000000);">
        <div class="text-center fav-div-animate" style="margin-top: 100px; margin-bottom: 200px;">
            <span class="rancho-regular text-6xl text-white">Crave More? Explore Every <br /> Flavor on Our Restaurant!</span>
            <div style="margin-top: 50px;">
                <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"><span class="raleway text-3xl" onclick="scrollToAllFoods();">Explore Foods</span></button>

            </div>
        </div>

    </section>

    <!-- Footer -->
    <section id="footer">
        <?php include "footer.php"; ?>
    </section>



    <script src="../script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>