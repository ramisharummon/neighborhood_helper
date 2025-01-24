<?php
//session_start();
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Accepted</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .navbar {
            background-color: #6C83C2;
            width: 100%;
            padding: 15px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar .logo {
            color: #fff;
            font-size: 1.8em;
            font-weight: bold;
            margin-right: auto;
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

        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 30px auto;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .container h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #6C83C2;
        }

        .container p {
            font-size: 1.1em;
            margin-bottom: 20px;
            color: #555;
        }

        .container .info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            text-align: left;
        }

        .container button {
            background-color: #6C83C2;
            color: white;
            font-size: 1.1em;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .container button:hover {
            background-color: #4a62a4;
        }

        .return-home {
            text-align: center;
            margin-top: 15px;
        }

        .return-home a {
            color: #6C83C2;
            font-size: 1.1em;
            text-decoration: none;
            font-weight: bold;
            transition: text-decoration 0.3s ease;
        }

        .return-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <div>
            <a href="home.php">Home</a>
            <a href="help_portal.php">View Help</a>
            <a href="group.php">Group</a>
            <a href="createevents.php">Event</a>
            <a href="review.php">Review</a>

        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2>Help Successfully Accepted</h2>
        <p>Thank you for offering your assistance! Below are the details of the help request you have accepted:</p>

        <div class="info">
            <p><strong>Title:</strong> Need help with groceries</p>
            <p><strong>Description:</strong> Assistance with picking up and delivering groceries for the elderly.</p>
            <p><strong>Type of Help:</strong> Physical Help</p>
            <p><strong>Urgency:</strong> High</p>
            <p><strong>Date:</strong> 2025-01-30</p>
            <p><strong>Time:</strong> 10:00 AM</p>
            <p><strong>Location:</strong> 123 Main Street</p>
        </div>

        <button onclick="window.location.href='contact_requester.php';">Contact Requester</button>
    </div>

    <div class="return-home">
        <a href="home.php">Return to Home</a>
    </div>
</body>
</html>
