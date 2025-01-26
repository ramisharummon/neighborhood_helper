<?php
//session_start();
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Offer</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .navbar {
            background-color: #6C83C2;
            width: 100%;
            padding: 15px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            position: fixed; 
            justify-content: center;
        }

        .navbar .logo {
            color: #fff;
            font-size: 1.8em;
            font-weight: bold;
            margin-right: auto; /* Align logo to the left */
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #4a62a4;
        }

        .success-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 60px); /* Adjust for navbar height */
        }

        .success-container .tick-icon {
            font-size: 100px;
            color: #28a745;
        }

        .success-container h1 {
            font-size: 2.5em;
            color: #28a745;
            margin: 20px 0;
        }

        .success-container p {
            font-size: 1.2em;
            color: #555;
        }

        .return-home {
            margin-top: 20px;
        }

        .return-home a {
            background-color: #6C83C2;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .return-home a:hover {
            background-color: #4a62a4;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <div>
            <a href="home.php">Home</a>
            <a href="offer_help.php">Offer Help</a>
            <a href="available_help.php">Available Help</a>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<p>Error: You must be logged in to submit an offer.</p>";
            exit;
        }

        // Get and sanitize form inputs
        $userID = $_SESSION['user_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $category = htmlspecialchars(trim($_POST['category']));
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
        $availability = htmlspecialchars(trim($_POST['availability']));
        $status = htmlspecialchars(trim($_POST['status']));

        // Input validation
        if (empty($title) || empty($description) || empty($category) || empty($availability) || empty($status)) {
            echo "<p>Error: All fields are required.</p>";
            exit;
        }

        if (!in_array($status, ['Active', 'Inactive'])) {
            echo "<p>Error: Invalid status value.</p>";
            exit;
        }

        try {
            // Prepare and execute the SQL query
            $stmt = $conn->prepare(
                "INSERT INTO helpoffer (UserID, Title, Description, Category, Price, Availability, Status, OfferDate)
                 VALUES (:userID, :title, :description, :category, :price, :availability, :status, NOW())"
            );

            // Bind parameters
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':availability', $availability, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            // Execute query
            $stmt->execute();

            // Display success message
            echo '
            <div class="success-container">
                <div class="tick-icon">&#10003;</div>
                <h1>Offer Successfully Submitted!</h1>
                <p>Thank you for your contribution to the community.</p>
                <div class="return-home">
                    <a href="home.php">Return to Home</a>
                </div>
            </div>
            ';
        } catch (PDOException $e) {
            echo "<p>Error: Unable to submit your offer. Please try again later.</p>";
            error_log("Database error: " . $e->getMessage());
        }
    } else {
        echo "<p>Invalid request method.</p>";
    }
    ?>
</body>
</html>
