<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Help</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .navbar {
            background-color: #7297cf;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
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
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            width: 100%;
            max-width: 500px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-container input,
        .form-container textarea,
        .form-container select,
        .form-container button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container textarea {
            resize: vertical;
        }
        .form-container button {
            background-color:#7297cf;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color:#7297cf;
        }
        .return-home {
            margin-top: auto;
            padding: 20px;
        }
        .return-home a {
            text-decoration: none;
            color: #007BFF;
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
        <a href="home.php">Home</a>
        <a href="offer_help.php">Offer Help</a>
        <a href="available_help.php">Available Help</a>
        <div class="search-bar">
            <form method="GET" action="search.php">
                <input type="text" name="query" placeholder="Search here...">
                <button type="submit">Search</button>
            </form>
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