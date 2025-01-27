<?php
session_start();
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Help</title>
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
            justify-content: space-between;
        }

        .navbar .logo {
            color: #fff;
            font-size: 1.8em;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #4a62a4;
        }

        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 30px auto;
            max-width: 600px;
            width: 100%;
        }

        .form-container h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 25px;
            color: #6C83C2;
        }

        .form-container label {
            font-size: 1.1em;
            margin-bottom: 8px;
            color: #555;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            transition: border 0.3s ease, background-color 0.3s ease;
        }

        .form-container button {
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

        .form-container button:hover {
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
            <a href="offer_help.php">Offer Help</a>
            <a href="available_help.php">Available Help</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-container">
        <h2>Request Help</h2>
        <form action="submit_request.php" method="POST">
            <label for="title">Help Title:</label>
            <input type="text" id="title" name="title" placeholder="E.g., Need help with groceries" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Provide details about the help you need" required></textarea>

            <label for="type">Type of Help:</label>
            <select id="type" name="type" required>
                <option value="physical">Physical Help</option>
                <option value="technical">Technical Help</option>
                <option value="emotional">Emotional Support</option>
                <option value="other">Other</option>
            </select>

            <label for="urgency">Urgency:</label>
            <select id="urgency" name="urgency" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" placeholder="E.g., 123 Main Street" required>

            <button type="submit">Post Request</button>
        </form>
    </div>

    <div class="return-home">
        <a href="home.php">Return to Home</a>
    </div>
</body>
</html>