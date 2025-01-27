<?php
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

// Retrieve UserID from the session
$UserID = $_SESSION['user_id'];

// Retrieve form data
$title = $_POST['title'];
$description = $_POST['description'];
$type = $_POST['type'];
$urgency = $_POST['urgency'];
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$status = 'Pending'; // Default status for a new request
$requestDate = date('Y-m-d H:i:s'); // Current date and time

$success = false;
$errorMessage = "";

try {
    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO helprequest (UserID, Title, Description, Category, UrgencyLevel, Location, RequestDate, TimeFrame, Status) 
                            VALUES (:UserID, :title, :description, :type, :urgency, :location, :requestDate, :time, :status)");

    // Bind parameters
    $stmt->bindParam(':UserID', $UserID);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':urgency', $urgency);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':requestDate', $requestDate);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':status', $status);

    // Execute the query
    $stmt->execute();
    $success = true;
} catch (PDOException $e) {
    $errorMessage = "Error: Unable to submit your request. Please try again later.";
    error_log("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Request</title>
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

        .success-container,
        .error-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 60px); /* Adjust for navbar height */
        }

        .success-container .tick-icon,
        .error-container .error-icon {
            font-size: 100px;
            color: #28a745;
        }

        .success-container h1,
        .error-container h1 {
            font-size: 2.5em;
            color: #28a745;
            margin: 20px 0;
        }

        .error-container h1 {
            color: #dc3545;
        }

        .success-container p,
        .error-container p {
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
            <a href="group.php">Group</a>
            <a href="createevents.php">Event</a>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="success-container">
            <div class="tick-icon">&#10003;</div>
            <h1>Request Successfully Submitted!</h1>
            <p>Your request has been posted successfully.</p>
            <div class="return-home">
                <a href="home.php">Return to Home</a>
            </div>
        </div>
    <?php else: ?>
        <div class="error-container">
            <div class="error-icon">&#10007;</div>
            <h1>Submission Failed</h1>
            <p><?= htmlspecialchars($errorMessage); ?></p>
            <div class="return-home">
                <a href="home.php">Return to Home</a>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
