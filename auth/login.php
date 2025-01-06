<?php
session_start();
include('../db.php');



if (isset($_SESSION['user_id'])) {
    // Redirect to profile if user is already logged in
    header("Location: ../profile/profile_view.php");
    exit();
}

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE Email = :email AND Password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    

    if($user) {
        // User found, redirect to profile page
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user'] = json_encode($user);
        header("Location: ../profile/profile_view.php");
        exit();
        
    } else {
        // User not found, redirect to login page with error
        $_SESSION['error'] = 'Incorrect email or password';
        header("Location: login.php");
        exit();
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">


    <title>Log In | Neighborhood Helper</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&amp;display=swap"
        rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <style>
    body {
        font-family: "Inter", sans-serif;
    }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer=""></script>

</head>

<body translate="no" class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">






    <div class="max-w-screen-xl m-0 sm:m-20 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div>

            </div>
            <div class="mt-12 flex flex-col items-center">
                <h2 class="text-xl xl:text-2xl font-extrabold">
                    Log In for Neighborhood Helper
                </h2>
                <div class="w-full flex-1 mt-8">

                    <div class="mx-auto max-w-xs">
                        <?php if (isset($_SESSION['error'])) { ?>

                        <div role="alert mb-2"
                            class="mt-3 relative flex flex-col w-full p-3 text-sm text-white bg-red-500 rounded-md">
                            <p class="flex text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="h-5 w-5 mr-2 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z">
                                    </path>
                                </svg>
                                Failed
                            </p>
                            <p class="ml-4 p-3">
                                Something went wrong. Please try again. Error: Incorrect email or password.
                            </p>

                        </div>

                        <?php } ?>
                        <?php unset($_SESSION['error']); ?>

                        <form action="login.php" method="POST" class="mt-2">
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                type="email" placeholder="Email" name="email">
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="password" placeholder="Password" name="password">
                            <button
                                class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 -ml-2" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-login-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                    <path d="M3 12h13l-3 -3" />
                                    <path d="M13 15l3 -3" />
                                </svg>
                                <span class="ml-3">
                                    Login
                                </span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                style="background-image: url('../assets/uploads/others/login_back.svg');">
            </div>
        </div>
    </div>


</body>

</html>