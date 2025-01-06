<?php

include('../db.php');

if (isset($_SESSION['user_id'])) {
    // Redirect to profile if user is already logged in
    header("Location: ../profile/profile_view.php");
    exit();
}


if (isset($_POST['Email']) && isset($_POST['Password']) && isset($_POST['Name']) && isset($_POST['Phone']) && isset($_POST['Location']) && isset($_POST['Bio'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $name = $_POST['Name'];
    $phone = $_POST['Phone'];
    $location = $_POST['Location'];
    $bio = $_POST['Bio'];

    // DB check if Email or Phone already exists

    $query = "SELECT * FROM user WHERE Email = :email OR Phone = :phone";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User found, redirect to login page with error
        $_SESSION['error'] = 'Email or Phone already exists. Please Login to continue.';
        header("Location: login.php");
        exit();
    }

    $query = "INSERT INTO user (Email, Password, Name, Phone, Location, Bio) VALUES (:email, :password, :name, :phone, :location, :bio)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':bio', $bio);
    $stmt->execute();

    // Redirect to login page

    $_SESSION['success'] = 'Registration successful. Please login to continue.';
    header("Location: login.php");
    exit();

    
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">


    <title>Registration | Neighborhood Helper</title>
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
                    Sign up for Neighborhood Helper
                </h2>
                <div class="w-full flex-1 mt-8">

                    <div class="mx-auto max-w-xs">
                        <form action="registration.php" method="POST">
                            <div class="overflow-y-auto scrollbar-auto h-56 [&::-webkit-scrollbar]:[width:30px] [&::-webkit-scrollbar-thumb]:bg-red-500">
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                    type="email" placeholder="Email" name="Email">
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="password" placeholder="Password" name="Password">

                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="text" placeholder="Name" name="Name">

                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="text" placeholder="Phone" name="Phone">

                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="text" placeholder="Location" name="Location">

                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="text" placeholder="Bio" name="Bio">

                            </div>
                            <button
                                class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <path d="M20 8v6M23 11h-6"></path>
                                </svg>
                                <span class="ml-3">
                                    Sign Up
                                </span>
                            </button>
                        </form>

                        <p class="mt-6 text-xs text-gray-600 text-center">
                            Already have an account?
                            <a href="login.php" class="border-b border-gray-500 border-dotted">
                                Login here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                style="background-image: url('../assets/uploads/others/registration_back.svg');">
            </div>
        </div>
    </div>










</body>

</html>