<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="input.css">

    <link rel="icon" href="../resources/logo.svg" />
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-full flex h-screen justify-center items-center backgrnd-img">

        <div class="flex justify-center items-center p-9 w-full">
            <div class="rounded-lg px-12 py-9 main-width" style="background-color: rgba(0, 0, 0, 0.77); ">

                <div class="signupdiv ">


                    <div id="signinbox" class=" signin-signup-div-animate ">
                        <!-- Sign In Form -->
                        <form>


                            <div class="w-full flex justify-center items-center mb-5">
                                <span class="text-white rajdhani-light text-3xl font-semibold">Admin Sign In</span>
                            </div>

                            <div class="w-full grid gap-6 mb-6 mt-6 md:grid-cols-2 ">


                                <div>
                                    <label for="signin_email" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" id="signin_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required />
                                </div>

                                <div class="mb-3">
                                    <label for="signin_password" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Password</label>
                                    <div class="flex">
                                        <input type="password" id="signin_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" minlength="5" maxlength="15" required />
                                        <div id="showSigninPassword" class="text-white cursor-pointer border rounded-lg border-gray-600 bg-gray-700 py-2 px-3 flex justify-center items-center rajdhani-light" onclick="signInPasswordSHow()">Show</div>
                                    </div>
                                </div>


                            </div>

                            <div id="incorrectPassword" class="hidden mb-3 text-red-500 rajdhani-light font-medium">Passwords is incorrect.</div>

                            <div class="flex w-full">

                                <div class="flex w-1/2 items-start mb-6">
                                </div>
                                <div class="flex w-1/2 items-end mb-6">
                                    <div class="flex w-full items-start justify-end text-end px-3">
                                        <a for="forget_pw" class="ms-2 text-md rajdhani-light font-medium text-gray-900 dark:text-gray-300 underline cursor-pointer">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-center items-center">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg rajdhani-light w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="adminSignIn(event)">Sign In</button>
                            </div>


                        </form>
                    </div>



                </div>



            </div>
        </div>
    </div>


    <script src="../script.js"></script>
</body>

</html>