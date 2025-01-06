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

if(isset($user['ProfilePicture']) && $user['ProfilePicture'] != null){
    $profile_picture = $user['ProfilePicture'];
} else {
    $profile_picture = null;
}


if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $interests = $_POST['interests'];
    $bio = $_POST['bio'];


    $query = "UPDATE user SET Name = :name, Email = :email, Phone = :phone, Location = :location, Interests = :interests, Bio = :bio WHERE UserID = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':interests', $interests);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $_SESSION['user'] = json_encode([
        'UserID' => $user_id,
        'Name' => $name,
        'Email' => $email,
        'Phone' => $phone,
        'Location' => $location,
        'Interests' => $interests,
        'Bio' => $bio
    ]);

   

    header("Location: profile_view.php");
    exit();

}

if(isset($_POST['update_image'])){
    $profile_picture = time();
    $profile_picture_temp = $_FILES['profile']['tmp_name'];

    if($profile_picture){
        move_uploaded_file($profile_picture_temp, "../assets/uploads/user-images/$profile_picture");
    } else {
        $profile_picture = $user['ProfilePicture'];
    }

    $query = "UPDATE user SET ProfilePicture = :profile_picture WHERE UserID = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':profile_picture', $profile_picture);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $_SESSION['user'] = json_encode([
        'UserID' => $user_id,
        'Name' => $user['Name'],
        'Email' => $user['Email'],
        'Phone' => $user['Phone'],
        'Location' => $user['Location'],
        'Interests' => $user['Interests'],
        'Bio' => $user['Bio'],
        'ProfilePicture' => $profile_picture
    ]);

    header("Location: profile_view.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../assets/js/profile.js" defer=""></script>
</head>

<body
    class="bg-gradient-to-br from-gray-200 via-[#9D81B3] to-gray-400 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 font-normal leading-relaxed text-gray-900 shadow-2xl">

        <!-- Profile Picture -->
        <div class="text-center mb-6">
            <div class="w-full text-right">
                <a class="text-3xl font-bold text-[#9D81B3] mb-3" href="https://google.com">?</a>
            </div>
            <form action="profile_view.php" method="POST" enctype="multipart/form-data">
                <img src="<?php echo $profile_picture ? '../assets/uploads/user-images/' . $profile_picture : 'https://i.pravatar.cc/300'; ?>"
                    alt="Profile Picture" id="profile-picture"
                    class="rounded-full w-32 h-32 mx-auto border-4 border-[#9D81B3] mb-4 transition-transform duration-300 hover:scale-110 ring ring-gray-300">
                <input type="file" name="profile" id="upload_profile" hidden required>
                <input type="hidden" name="update_image" value="<?php echo $user_id; ?>">
                <label for="upload_profile" class="inline-flex items-center">
                    <svg class="w-5 h-5 text-[#9D81B3]" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                        </path>
                    </svg>
                </label>
                <button
                    class="bg-[#9D81B3] text-white px-4 py-2 mt-2 rounded-lg hover:bg-[#7C6790] active:bg-[#624E73] transition-colors duration-300 ring ring-gray-300 hover:ring-[#7C6790]"
                    type="submit" id="profile-image-submit-button" disabled>
                    Change Profile Picture
                </button>
                

            </form>
        </div>

        <!-- Bio Section -->
        <!-- Profile Update Form -->
        <form class="space-y-4 mt-5" id="profile-form" method="POST" action="profile_view.php">
            <div>
                <h3 class="text-2xl font-bold text-[#9D81B3] mb-4">Bio</h3>
                <textarea name="bio"
                    class="w-full h-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"
                    placeholder="Write something about yourself..."><?php echo htmlspecialchars($user['Bio']); ?></textarea>
            </div>


            <!-- Name -->
            <input type="hidden" name="update" value="<?php echo $user_id; ?>">
            <div>
                <label for="name" class="block text-sm font-medium text-[#9D81B3]">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"
                    value="<?php echo htmlspecialchars($user['Name']); ?>">
            </div>

            <!-- Contact Information -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#9D81B3]">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"
                    value="<?php echo htmlspecialchars($user['Email']); ?>">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-[#9D81B3]">Phone</label>
                <input type="tel" id="phone" name="phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"
                    value="<?php echo htmlspecialchars($user['Phone']); ?>">
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-[#9D81B3]">Location</label>
                <input type="text" id="location" name="location"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"
                    value="<?php echo htmlspecialchars($user['Location']); ?>">
            </div>

            <!-- Interests Section -->
            <div>
                <h3 class="text-2xl font-bold text-[#9D81B3] mb-4">Interests</h3>
                <textarea name="interests"
                    class="w-full h-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-[#9D81B3] focus:border-[#9D81B3] text-gray-700"><?php echo htmlspecialchars($user['Interests']); ?></textarea>
            </div>

            <!-- Save and Cancel Buttons -->
            <div class="flex justify-end space-x-4 mt-10">
                <button type="button"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 active:bg-gray-500">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-[#9D81B3] text-white rounded-lg hover:bg-[#7C6790] active:bg-[#624E73]">Save
                    Changes</button>
            </div>
        </form>

    </div>
</body>

</html>