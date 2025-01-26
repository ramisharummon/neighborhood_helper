<?php
// Any PHP logic you already have here
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighborhood Helper</title>
    <!-- Include Lottie Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.0/lottie.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #7297cf; /* Blue background */
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar .logo {
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            margin-right: auto;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #5a78a4; /* Slightly darker blue on hover */
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
            margin-right: 10px;
        }

        .navbar input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .navbar button {
            background-color: white;
            color: #5D3A9B;
            border: none;
            padding: 6px 12px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar button:hover {
            background-color: #E3E3E3;
        }

        .navbar .login {
            background-color: #7297cf;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }

        .navbar .login:hover {
            background-color: #5a78a4;
        }

        /* Lottie Animation Styling */
        #lottie-container {
            width: 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 140px; /* Below the navbar */
            left: 0;
            z-index: 1;
            background: white; /* Optional: Ensures background consistency */
        }

        /* Main content below Lottie animation */
        .content {
            margin-top: 450px; /* Ensure content appears below Lottie animation */
            text-align: center;
        }

        .register-text {
            margin-top: 20px;
        }

        /* Styling for Sign up link */
        .signup-link {
            background-color: #7297cf;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .signup-link:hover {
            background-color: #5a78a4; /* Slightly darker shade for hover effect */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <a href="home.php">Home</a>
        <a href="help_portal.php">View Help</a>
        <a href="<?php echo isset($_SESSION['user_id']) ? 'group.php' : 'login.php'; ?>">Group</a>
        <a href="<?php echo isset($_SESSION['user_id']) ? 'createevents.php' : 'login.php'; ?>">Event</a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'review.php' : 'login.php'; ?>">Review</a>
           
       
        <!-- "Review" link logic -->
       
            <?php if(isset($_SESSION['user_id'])){ ?>

        <a href="logout.php">Logout</a>
        <?php } ?>
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <button>Search</button>
        </div>
        <?php if(!isset($_SESSION['user_id'])){ ?>
        <a href="login.php" class="login">Login</a>
        <?php } ?>
    </div>

    <!-- Lottie Animation -->
    <div id="lottie-container"></div>

    <!-- Main Content -->
    <div class="content">
        <h2>Your Trusted Helper</h2>
        <?php
        // Lottie JSON file URL (replace with your own JSON if necessary)
        $lottieJsonUrl = "/neighborhood_helper/assets/uploads/others/neighbor.json";
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const animation = lottie.loadAnimation({
                    container: document.getElementById('lottie-container'), // Bind to the container
                    renderer: 'svg', // Rendering mode
                    loop: true, // Infinite loop
                    autoplay: true, // Auto-play enabled
                    path: '<?php echo $lottieJsonUrl; ?>' // JSON file URL
                });

                // Set animation speed
                animation.setSpeed(2);
            });
        </script>
        <div class="register-text">
            <?php if(!isset($_SESSION['user_id'])){ ?>
                <p>Didn't sign up yet? <a href="registration.php" class="signup-link">Sign up here</a></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>