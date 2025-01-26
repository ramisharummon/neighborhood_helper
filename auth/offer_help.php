<?php
session_start();
include('../db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Help</title>
    <style>
        /* Basic Reset */
         body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #7297cf;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            position: fixed; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .navbar .menu-icon {
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .navbar .menu-icon:hover {
            color: #d9d9d9;
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
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
            <a href="help_portal.php">View Help</a>
          
            <a href="review.php">Review</a> 
            <a href="group.php">Group</a> 
            <a href="createevents.php">Event</a> <!-- Added Review link -->
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-container">
        <h2>Offer Help</h2>
        <form action="submit_offer.php" method="POST">
            <label for="title">Help Title:</label>
            <input type="text" id="title" name="title" placeholder="E.g., Can assist with groceries" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Provide details about the help you can offer" required></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Home Repairs">Home Repairs</option>
                <option value="Technical Help">Technical Help</option>
                <option value="Personal Support">Personal Support</option>
                <option value="Other">Other</option>
            </select>

            <label for="price">Price (in Tk):</label>
            <input type="number" id="price" name="price" placeholder="Tk 100" step="100" required>

            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability" placeholder="Weekends, 9 AM - 5 PM" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <button type="submit">Post Offer</button>
        </form>
    </div>

    <div class="return-home">
        <a href="home.php">Return to Home</a>
    </div>
</body>
</html>
