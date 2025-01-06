<?php
session_start();
include('../db.php');



if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

$user = json_decode($_SESSION['user'], true);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-200 via-[#9D81B3] to-gray-400 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 font-normal leading-relaxed text-gray-900 shadow-2xl">

        <!-- Profile Picture -->
        <div class="text-center mb-6">
            <img src="<?php echo $profile_picture ? 'uploads/' . $profile_picture : 'https://i.pravatar.cc/300'; ?>" alt="Profile Picture" id="profile-picture" class="rounded-full w-32 h-32 mx-auto border-4 border-[#9D81B3] mb-4 transition-transform duration-300 hover:scale-110 ring ring-gray-300">
            <input type="file" name="profile" id="upload_profile" hidden required>
            <label for="upload_profile" class="inline-flex items-center">
                <svg class="w-5 h-5 text-[#9D81B3]" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"></path>
                </svg>
            </label>
            <button class="bg-[#9D81B3] text-white px-4 py-2 mt-2 rounded-lg hover:bg-[#7C6790] active:bg-[#624E73] transition-colors duration-300 ring ring-gray-300 hover:ring-[#7C6790]">
                Change Profile Picture
            </button>
        </div>

        <!-- Bio Section -->
        <div>
            <h3 class="text-2xl font-bold text-[#9D81B3] mb-4">Bio</h3>
            <textarea class="w-full h-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700" placeholder="Write something about yourself..."><?php echo htmlspecialchars($user['Bio']); ?></textarea>
        </div>

        <!-- Profile Update Form -->
        <form class="space-y-4 mt-5" id="profile-form" method="POST" action="update_profile.php" enctype="multipart/form-data">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-[#9D81B3]">Name</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700" value="<?php echo htmlspecialchars($user['Name']); ?>">
            </div>

            <!-- Contact Information -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#9D81B3]">Email</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700" value="<?php echo htmlspecialchars($user['Email']); ?>">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-[#9D81B3]">Phone</label>
                <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700" value="<?php echo htmlspecialchars($user['Phone']); ?>">
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-[#9D81B3]">Location</label>
                <input type="text" id="location" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700" value="<?php echo htmlspecialchars($user['Location']); ?>">
            </div>

            <!-- Interests Section -->
            <div>
                <h3 class="text-2xl font-bold text-[#9D81B3] mb-4">Interests</h3>
                <textarea name="interests" class="w-full h-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"><?php echo htmlspecialchars($user['Interests']); ?></textarea>
            </div>

            <!-- Save and Cancel Buttons -->
            <div class="flex justify-end space-x-4 mt-10">
                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 active:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#9D81B3] text-white rounded-lg hover:bg-[#7C6790] active:bg-[#624E73]">Save Changes</button>
            </div>
        </form>

    </div>
</body>
</html>
