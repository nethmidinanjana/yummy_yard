<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="input.css">
    <link rel="icon" href="../resources/logo.svg" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" /> -->

    <!-- Include Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="w-full h-screen flex justify-center items-center bg">

    <div class="flex justify-center items-center p-9 w-full">
        <div class="rounded-lg px-12 py-9 main-width" style="background-color: rgba(0, 0, 0, 0.77); ">

            <div class="signupdiv ">
                <div id="signupbox" class="signin-signup-div-animate ">
                    <form>

                        <div class="w-full flex justify-center items-center mb-5">
                            <span class="text-white rajdhani-light text-3xl font-semibold">Sign Up</span>
                        </div>

                        <div class="w-full grid gap-6 mb-3 mt-6 md:grid-cols-2 ">

                            <div>
                                <label for="first_name" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">First name</label>
                                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" maxlength="30" required />
                            </div>
                            <div>
                                <label for="last_name" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Last name</label>
                                <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" maxlength="30" required />
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required />
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Contact number</label>
                                <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" pattern="^07[01245678][0-9]{7}$" required />

                            </div>
                            <div class="mb-2">
                                <label for="password" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Password</label>
                                <div class="flex">
                                    <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" minlength="5" maxlength="15" required />
                                    <div id="showPassword" class="text-white cursor-pointer border rounded-lg border-gray-600 bg-gray-700 py-2 px-3 flex justify-center items-center rajdhani-light" onclick="passwordShow()">Show</div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="confirm_password" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Confirm password</label>
                                <div class="flex">
                                    <input type="password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" minlength="5" maxlength="15" required />
                                    <div id="showConfirmPassword" class="text-white cursor-pointer border rounded-lg border-gray-600 bg-gray-700 py-2 px-3 flex justify-center items-center rajdhani-light" onclick="confirmPasswordShow()">Show</div>
                                </div>
                            </div>
                        </div>

                        <div id="passwordMatchError" class="hidden text-black  rajdhani-light font-semibold border rounded-lg px-4 py-2 bg-red-300 border-red-300 w-full mb-5">Passwords do not match.</div>

                        <div class="w-full flex justify-center items-center">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg rajdhani-light w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="signUp(event);">Sign Up</button>
                        </div>


                    </form>
                </div>

                <div id="signinbox" class="hidden signin-signup-div-animate ">
                    <!-- Sign In Form -->
                    <form>

                        <div class="w-full flex justify-center items-center mb-5">
                            <span class="text-white rajdhani-light text-3xl font-semibold">Sign In</span>
                        </div>

                        <div class="w-full grid gap-6 mb-6 mt-6 md:grid-cols-2 ">

                            <?php

                            $email = "";
                            $password = "";

                            if (isset($_COOKIE["email"])) {
                                $email = $_COOKIE["email"];
                            }

                            if (isset($_COOKIE["password"])) {
                                $password = $_COOKIE["password"];
                            }

                            ?>

                            <div>
                                <label for="signin_email" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="signin_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required value="<?php echo $email; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="signin_password" class="block mb-2 text-lg rajdhani-light font-medium text-gray-900 dark:text-white">Password</label>
                                <div class="flex">
                                    <input type="password" id="signin_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" minlength="5" maxlength="15" required value="<?php echo $password; ?>" />
                                    <div id="showSigninPassword" class="text-white cursor-pointer border rounded-lg border-gray-600 bg-gray-700 py-2 px-3 flex justify-center items-center rajdhani-light" onclick="signInPasswordSHow()">Show</div>
                                </div>
                            </div>


                        </div>

                        <div id="incorrectPassword" class="hidden mb-3 text-red-500 rajdhani-light font-medium">Passwords is incorrect.</div>

                        <div class="flex w-full">

                            <div class="flex w-1/2 items-start mb-6">
                                <div class="flex items-center h-5">
                                    <input id="rememberme" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required checked />
                                </div>
                                <label for="rememberme" class="ms-2 text-md rajdhani-light font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                            </div>
                            <div class="flex w-1/2 items-end mb-6">
                                <div class="flex w-full items-start justify-end text-end px-3">
                                    <a for="forget_pw" id="forgotPasswordLink" class="ms-2 text-md rajdhani-light font-medium text-gray-900 dark:text-gray-300 underline cursor-pointer" onclick="forgotPassword()">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg rajdhani-light w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="signIn(event);">Sign In</button>
                        </div>


                    </form>
                </div>


                <div class="w-full flex justify-center items-center mt-5" onclick="changeView()">

                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" id="toggleLink">Already has an account? Sign In</a>

                </div>
            </div>

            <!-- Modal Structure -->
            <div id="resetPasswordModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white p-8 rounded-lg shadow-lg w-96">
                    <span class="close text-gray-400 float-right text-2xl cursor-pointer" onclick="closeModal()">&times;</span>
                    <h2 class="text-xl font-semibold mb-4">Reset Password</h2>
                    <form id="resetPasswordForm">
                        <label for="verification_code" class="block text-sm font-medium text-gray-700">Verification Code:</label>
                        <input type="text" id="verification_code" name="verification_code" required class="mt-1 p-2 border border-gray-300 rounded w-full">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mt-3">New Password:</label>
                        <div class="flex mt-1">
                            <input type="password" id="forgot_password" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="•••••••••" minlength="5" maxlength="15" required />
                            <div id="showForgotPassword" class="cursor-pointer mt-1 p-2 border border-gray-300 rounded w-fullr rajdhani-light" onclick="forgotPasswordSHow()">Show</div>
                        </div>
                        <label for="re_type_new_password" class="block text-sm font-medium text-gray-700 mt-3">Re-type New Password:</label>
                        <div class="flex">
                            <input type="password" id="forgot_passwordRT" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="•••••••••" minlength="5" maxlength="15" required />
                            <div id="showForgotPasswordRT" class="cursor-pointer mt-1 p-2 border border-gray-300 rounded w-fullr rajdhani-light" onclick="forgotPasswordRTSHow()">Show</div>
                        </div>
                        <button type="button" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" 
                        onclick="resetpw()">Submit</button>
                    </form>
                </div>
            </div>




        </div>
    </div>

    <script src="../script.js"></script>
</body>


</html>